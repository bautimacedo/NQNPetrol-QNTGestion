<?php

use App\Http\Controllers\Admin\UserManagementController;
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

Route::middleware(['auth', 'approved'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Panel de administración (solo admin)
    Route::middleware('role:admin')->group(function () {
        // Panel de seguridad
        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::post('/security/unblock/{id}', [SecurityController::class, 'unblockIp'])->name('security.unblock');
        
        // Gestión de usuarios pendientes
        Route::get('/admin/users/pending', [UserManagementController::class, 'pending'])->name('admin.users.pending');
        Route::post('/admin/users/{id}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
        Route::post('/admin/users/{id}/reject', [UserManagementController::class, 'reject'])->name('admin.users.reject');
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
    
    // Rutas de solo lectura para operator y admin (dashboard y visualización)
    Route::prefix('production')->name('production.')->group(function () {
        // RPAs - Solo lectura
        Route::get('drones', [ProductionDroneController::class, 'index'])->name('drones.index');
        Route::get('drones/{drone}', [ProductionDroneController::class, 'show'])->name('drones.show');
        
        // Misiones - Solo lectura
        Route::get('missions', [ProductionMissionController::class, 'index'])->name('missions.index');
        Route::get('missions/{mission}', [ProductionMissionController::class, 'show'])->name('missions.show');
        
        // Usuarios - Solo lectura
        Route::get('users', [AuthorizedUserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [AuthorizedUserController::class, 'show'])->name('users.show');
        
        // Baterías - Solo lectura
        Route::get('batteries', [BatteryController::class, 'index'])->name('batteries.index');
        Route::get('batteries/{battery}', [BatteryController::class, 'show'])->name('batteries.show');
        
        // Logs - Solo lectura
        Route::get('logs', [TelemetryLogController::class, 'index'])->name('logs.index');
        
        // Pozos - Solo lectura para operators, completo para admin
        Route::get('wells', [WellController::class, 'index'])->name('wells.index');
        Route::get('wells/{well}', [WellController::class, 'show'])->name('wells.show');
        
        // Licencias - Solo lectura para operators
        Route::get('licenses', [LicenseController::class, 'index'])->name('licenses.index');
    });
    
    // Rutas adicionales solo para admin (crear/editar licencias)
    Route::middleware('role:admin')->group(function () {
        Route::prefix('production')->name('production.')->group(function () {
            Route::post('licenses', [LicenseController::class, 'store'])->name('licenses.store');
            Route::resource('wells', WellController::class)->except(['index', 'show']);
        });
    });
});

// Resource Routes
Route::resource('pilots', PilotController::class)->only(['index', 'show', 'store']);
