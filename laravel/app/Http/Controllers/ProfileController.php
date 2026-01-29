<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\AuthorizedUser;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'first_name' => $validated['first_name'] ?? $user->first_name,
            'last_name' => $validated['last_name'] ?? $user->last_name,
            'email' => $validated['email'],
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Información personal actualizada exitosamente.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.edit')
                ->withErrors(['current_password' => 'La contraseña actual es incorrecta.'])
                ->withInput();
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * Update the pilot's mission password.
     */
    public function updateMissionPassword(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->hasRole('pilot')) {
            abort(403, 'Acceso denegado. Solo para pilotos.');
        }
        
        $authorizedUser = AuthorizedUser::where('web_user_id', $user->id)->first();
        
        if (!$authorizedUser) {
            return redirect()->route('profile.edit')
                ->withErrors(['error' => 'No se encontró tu perfil de piloto.'])
                ->withInput();
        }
        
        $request->validate([
            'mission_password' => 'nullable|string|min:4',
        ]);
        
        if ($request->filled('mission_password')) {
            $authorizedUser->update([
                'mission_password' => Hash::make($request->mission_password),
            ]);
            
            return redirect()->route('profile.edit')
                ->with('success', 'Contraseña de misión actualizada exitosamente.');
        }
        
        return redirect()->route('profile.edit')
            ->with('info', 'No se realizaron cambios.');
    }
}
