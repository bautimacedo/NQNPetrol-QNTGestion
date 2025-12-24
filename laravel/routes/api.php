<?php

use App\Http\Controllers\Api\AvailabilityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas de disponibilidad (accesibles desde n8n)
Route::prefix('availability')->group(function () {
    Route::get('/drones', [AvailabilityController::class, 'drones']);
    Route::get('/drones/{id}', [AvailabilityController::class, 'drone']);
    Route::get('/pilots', [AvailabilityController::class, 'pilots']);
    Route::get('/pilots/{id}', [AvailabilityController::class, 'pilot']);
});

// Rutas de API para producción (si es necesario)

// Rutas protegidas con middleware de Telegram Bot
Route::middleware(['api', 'telegram.bot'])->group(function () {
    // Aquí puedes agregar más endpoints que requieran autenticación por Telegram
});

