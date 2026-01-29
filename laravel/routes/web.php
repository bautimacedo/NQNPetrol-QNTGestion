<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Production\AuthorizedUserController;
use App\Http\Controllers\Production\BatteryController;
use App\Http\Controllers\Production\LicenseController as ProductionLicenseController;
use App\Http\Controllers\Production\ProductionDroneController;
use App\Http\Controllers\Production\ProductionMissionController;
use App\Http\Controllers\Production\TelemetryLogController;
use App\Http\Controllers\Production\WellController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\WaitingApprovalController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::middleware(['guest', \App\Http\Middleware\CheckBlockedIp::class])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Ruta de espera de aprobación y logout (sin middleware de aprobación)
Route::middleware('auth')->group(function () {
    Route::get('/waiting-approval', [WaitingApprovalController::class, 'index'])->name('waiting.approval');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil de usuario
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/profile/mission-password', [ProfileController::class, 'updateMissionPassword'])->name('profile.mission-password.update');
    
    // Mi Licencia (solo para pilots)
    Route::middleware('role:pilot')->group(function () {
        Route::get('/pilot/my-license', [\App\Http\Controllers\PilotLicenseController::class, 'myLicense'])->name('pilot.my-license');
        Route::put('/pilot/my-license', [\App\Http\Controllers\PilotLicenseController::class, 'update'])->name('pilot.my-license.update');
        Route::post('/pilot/my-license/update-document', [\App\Http\Controllers\PilotLicenseController::class, 'updateLicenseDocument'])->name('pilot.my-license.update-document');
    });
    
    // Panel de administración (solo admin)
    Route::middleware('role:admin')->group(function () {
        // Panel de seguridad
        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::post('/security/unblock/{id}', [SecurityController::class, 'unblockIp'])->name('security.unblock');
        
        // Gestión de usuarios
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/pending', [UserManagementController::class, 'pending'])->name('admin.users.pending');
        Route::get('/admin/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show');
        Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/admin/users/{id}/approve', [UserManagementController::class, 'approve'])->name('admin.users.approve');
        Route::post('/admin/users/{id}/make-admin', [UserManagementController::class, 'makeAdmin'])->name('admin.users.makeAdmin');
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
        
        // Gestión de Ubicaciones (Sites)
        Route::resource('sites', SiteController::class);
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
        Route::get('licenses', [ProductionLicenseController::class, 'index'])->name('licenses.index');
    });
    
    // Rutas adicionales solo para admin (crear/editar licencias)
    Route::middleware('role:admin')->group(function () {
        Route::prefix('production')->name('production.')->group(function () {
            Route::post('licenses', [ProductionLicenseController::class, 'store'])->name('licenses.store');
            Route::resource('wells', WellController::class)->except(['index', 'show']);
        });
    });

    // Rutas de Proveedores - Las rutas específicas deben ir ANTES de las rutas con parámetros
    Route::get('providers', [ProviderController::class, 'index'])->name('providers.index');
    
    // Rutas de Proveedores solo para admin (deben ir antes de providers/{provider})
    Route::middleware('role:admin')->group(function () {
        Route::get('providers/create', [ProviderController::class, 'create'])->name('providers.create');
        Route::post('providers', [ProviderController::class, 'store'])->name('providers.store');
        Route::get('providers/{provider}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
        Route::put('providers/{provider}', [ProviderController::class, 'update'])->name('providers.update');
        Route::delete('providers/{provider}', [ProviderController::class, 'destroy'])->name('providers.destroy');
    });
    
    // Rutas de lectura (deben ir DESPUÉS de las rutas específicas como 'create' y 'edit')
    Route::get('providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');

    // Rutas de Compras - Las rutas específicas deben ir ANTES de las rutas con parámetros
    Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    
    // Rutas de Compras solo para admin (deben ir antes de purchases/{purchase})
    Route::middleware('role:admin')->group(function () {
        Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
        Route::put('purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::delete('purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
        Route::post('purchases/{purchase}/upload-document', [PurchaseController::class, 'uploadDocument'])->name('purchases.upload-document');
        Route::delete('purchases/{purchase}/delete-document/{purchaseDocument}', [PurchaseController::class, 'deleteDocument'])->name('purchases.delete-document');
    });
    
    // Rutas de lectura (deben ir DESPUÉS de las rutas específicas como 'create' y 'edit')
    Route::get('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('purchases/{purchase}/download-document/{purchaseDocument}', [PurchaseController::class, 'downloadDocument'])->name('purchases.download-document');
});
