<?php

namespace App\Http\Middleware;

use App\Models\AuthorizedUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTelegramBot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $telegramId = $request->header('X-Telegram-Id') ?? $request->input('telegram_id');

        if (!$telegramId) {
            return response()->json([
                'error' => 'telegram_id is required',
                'message' => 'El telegram_id debe ser proporcionado en el header X-Telegram-Id o en el body de la petición',
            ], 401);
        }

        // Verificar que el telegram_id existe en la base de datos
        $pilot = AuthorizedUser::where('user_telegram_id', $telegramId)->first();

        if (!$pilot) {
            return response()->json([
                'error' => 'invalid_telegram_id',
                'message' => 'El telegram_id proporcionado no está registrado',
            ], 401);
        }

        // Verificar que el piloto está activo
        if ((int) $pilot->status !== 1) {
            return response()->json([
                'error' => 'pilot_inactive',
                'message' => 'El piloto asociado a este telegram_id está inactivo',
            ], 403);
        }

        // Agregar el piloto al request para uso posterior
        $request->merge(['authenticated_pilot' => $pilot]);

        return $next($request);
    }
}
