<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $ipAddress = $request->ip();
        $email = $request->email;
        $userAgent = $request->userAgent();

        // Verificar si la IP está bloqueada
        $blocked = BlockedIp::where('ip_address', $ipAddress)->first();
        if ($blocked) {
            LoginLog::create([
                'email' => $email,
                'ip_address' => $ipAddress,
                'success' => false,
                'user_agent' => $userAgent,
                'attempted_at' => now(),
            ]);
            
            throw ValidationException::withMessages([
                'email' => 'Tu IP ha sido bloqueada. Contacta al administrador.',
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Registrar login exitoso
            LoginLog::create([
                'email' => $email,
                'ip_address' => $ipAddress,
                'success' => true,
                'user_agent' => $userAgent,
                'attempted_at' => now(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        // Registrar login fallido
        LoginLog::create([
            'email' => $email,
            'ip_address' => $ipAddress,
            'success' => false,
            'user_agent' => $userAgent,
            'attempted_at' => now(),
        ]);

        // Verificar si hay 5 intentos fallidos consecutivos desde esta IP
        $recentFailedAttempts = LoginLog::where('ip_address', $ipAddress)
            ->where('success', false)
            ->orderBy('attempted_at', 'desc')
            ->take(5)
            ->get();

        if ($recentFailedAttempts->count() >= 5) {
            // Verificar que los últimos 5 sean consecutivos (sin éxito entre ellos)
            $allFailed = $recentFailedAttempts->every(fn($log) => !$log->success);
            
            if ($allFailed) {
                // Bloquear la IP
                BlockedIp::firstOrCreate(
                    ['ip_address' => $ipAddress],
                    [
                        'reason' => '5 intentos de login fallidos consecutivos',
                        'blocked_at' => now(),
                    ]
                );
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
