<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlockedIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        
        $blocked = BlockedIp::where('ip_address', $ipAddress)->first();
        
        if ($blocked) {
            abort(403, 'Tu IP ha sido bloqueada. Contacta al administrador.');
        }
        
        return $next($request);
    }
}
