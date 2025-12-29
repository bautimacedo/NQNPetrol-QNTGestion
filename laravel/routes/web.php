<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\Production\AuthorizedUserController;
use App\Http\Controllers\Production\BatteryController;
use App\Http\Controllers\Production\ProductionDroneController;
use App\Http\Controllers\Production\ProductionMissionController;
use App\Http\Controllers\Production\TelemetryLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resource Routes
Route::resource('pilots', PilotController::class)->only(['index', 'show', 'store']);

// Production Routes (Sincronización con DB de producción)
Route::prefix('production')->name('production.')->group(function () {
    Route::resource('drones', ProductionDroneController::class);
    Route::resource('missions', ProductionMissionController::class);
    Route::resource('users', AuthorizedUserController::class);
    Route::resource('batteries', BatteryController::class);
    Route::get('logs', [TelemetryLogController::class, 'index'])->name('logs.index');
});
