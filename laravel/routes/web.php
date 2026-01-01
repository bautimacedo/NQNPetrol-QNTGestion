<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\Production\AuthorizedUserController;
use App\Http\Controllers\Production\BatteryController;
use App\Http\Controllers\Production\LicenseController;
use App\Http\Controllers\Production\ProductionDroneController;
use App\Http\Controllers\Production\ProductionMissionController;
use App\Http\Controllers\Production\TelemetryLogController;
use App\Http\Controllers\Production\WellController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::middleware(['guest', \App\Http\Middleware\CheckBlockedIp::class])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Panel de seguridad (solo admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::post('/security/unblock/{id}', [SecurityController::class, 'unblockIp'])->name('security.unblock');
    });
    
    // Rutas protegidas por roles
    Route::middleware('role:admin')->group(function () {
        // Rutas de edición y borrado solo para admin
        Route::prefix('production')->name('production.')->group(function () {
            Route::resource('drones', ProductionDroneController::class)->except(['index', 'show']);
            Route::resource('missions', ProductionMissionController::class)->except(['index', 'show']);
            Route::resource('users', AuthorizedUserController::class)->except(['index', 'show']);
            Route::resource('batteries', BatteryController::class)->except(['index', 'show']);
        });
    });
    
    // Rutas de solo lectura para operator y admin
    Route::prefix('production')->name('production.')->group(function () {
        Route::get('drones', [ProductionDroneController::class, 'index'])->name('drones.index');
        Route::get('drones/{drone}', [ProductionDroneController::class, 'show'])->name('drones.show');
        Route::get('missions', [ProductionMissionController::class, 'index'])->name('missions.index');
        Route::get('missions/{mission}', [ProductionMissionController::class, 'show'])->name('missions.show');
        Route::get('users', [AuthorizedUserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [AuthorizedUserController::class, 'show'])->name('users.show');
        Route::get('batteries', [BatteryController::class, 'index'])->name('batteries.index');
        Route::get('batteries/{battery}', [BatteryController::class, 'show'])->name('batteries.show');
        Route::resource('wells', WellController::class);
        Route::resource('licenses', LicenseController::class)->only(['index', 'store']);
        Route::get('logs', [TelemetryLogController::class, 'index'])->name('logs.index');
    });
});

// Resource Routes
Route::resource('pilots', PilotController::class)->only(['index', 'show', 'store']);
