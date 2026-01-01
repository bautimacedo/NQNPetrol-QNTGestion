<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_approved) {
            // Si el usuario no tiene rol y no está aprobado, redirigir a página de espera
            if (Auth::user()->roles->count() === 0) {
                return redirect()->route('waiting.approval');
            }
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Tu cuenta está pendiente de revisión. Un administrador de Quintana Energy debe aprobar tu acceso.');
        }

        return $next($request);
    }
}
