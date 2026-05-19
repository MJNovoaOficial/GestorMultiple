<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\IpStatusController;
use App\Http\Controllers\IpRangeImportController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\EmailCredentialController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\PasswordRevealController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplyController;

Route::get('/', function () {
   
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware(['auth', 'verified'])
            ->name('dashboard');
        /*
        |--------------------------------------------------------------------------
        | Módulo de Usuarios
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);
        /*
        |--------------------------------------------------------------------------
        | Módulo Gestor Passwords
        |--------------------------------------------------------------------------
        */
        
        Route::post('/passwords/generate',[PasswordGeneratorController::class, 'generate'])
            ->name('passwords.generate');

        Route::post('/passwords/{password}/reveal',[PasswordRevealController::class, 'reveal'])
            ->name('passwords.reveal');

        Route::resource('passwords', EmailCredentialController::class);

        /*
        |--------------------------------------------------------------------------
        | Módulo Gestor IP
        |--------------------------------------------------------------------------
        */

        Route::get('/ip-addresses', [IpAddressController::class, 'index'])
            ->name('ip-addresses.index');

        Route::put('/ip-addresses/{ipAddress}', [IpAddressController::class, 'update'])
            ->name('ip-addresses.update');
        
        Route::post('/ip-addresses/ping', [IpAddressController::class, 'ping'])
            ->name('ip-addresses.ping');

        Route::post('/ip-addresses/{ip}/release', [IpAddressController::class, 'release'])
            ->name('ip-addresses.release');

        /*
        |--------------------------------------------------------------------------
        | Módulo de suministros de impresoras
        |--------------------------------------------------------------------------
        */
        Route::get('/supplies', [SupplyController::class, 'index'])
            ->name('supplies.index');
        Route::get('/supplies/create', [SupplyController::class, 'create'])
            ->name('supplies.create');
        Route::get('/supplies/{supply}/edit', [SupplyController::class, 'edit'])
            ->name('supplies.edit');
        Route::put('/supplies/{supply}', [SupplyController::class, 'update'])
            ->name('supplies.update');
        Route::post('/supplies', [SupplyController::class, 'store'])
            ->name('supplies.store');
        Route::post('/supplies/{supply}/add',[SupplyController::class, 'addStock'])
            ->name('supplies.add');
        Route::post('/supplies/{supply}/remove',[SupplyController::class, 'removeStock'])
            ->name('supplies.remove');
        Route::delete('/supplies/{supply}',[SupplyController::class, 'destroy'])
            ->name('supplies.destroy');
        
        /*
        |--------------------------------------------------------------------------
        | Módulo de Auditoría
        |--------------------------------------------------------------------------
        */
        Route::get('/audits',[AuditController::class, 'index'])
            ->name('audits.index');
        /*
        |--------------------------------------------------------------------------
        | Solo Superadmin
        |--------------------------------------------------------------------------
        */
        Route::middleware(['superadmin'])->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Sucursales
            |--------------------------------------------------------------------------
            */

            Route::get('/branches', [BranchController::class, 'index'])
                ->name('branches.index');

            Route::get('/branches/create', [BranchController::class, 'create'])
                ->name('branches.create');

            Route::post('/branches', [BranchController::class, 'store'])
                ->name('branches.store');

            Route::get('/branches/{branch}/edit', [BranchController::class, 'edit'])
                ->name('branches.edit');

            Route::put('/branches/{branch}', [BranchController::class, 'update'])
                ->name('branches.update');

            Route::delete('/branches/{branch}', [BranchController::class, 'destroy'])
                ->name('branches.destroy');


            /*
            |--------------------------------------------------------------------------
            | Departments
            |--------------------------------------------------------------------------
            */

            Route::get('/departments', [DepartmentController::class, 'index'])
                ->name('departments.index');

            Route::get('/departments/create', [DepartmentController::class, 'create'])
                ->name('departments.create');

            Route::post('/departments', [DepartmentController::class, 'store'])
                ->name('departments.store');

            Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
                ->name('departments.edit');

            Route::put('/departments/{department}', [DepartmentController::class, 'update'])
                ->name('departments.update');

            Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
                ->name('departments.destroy');


            /*
            |--------------------------------------------------------------------------
            | Device Types
            |--------------------------------------------------------------------------
            */

            Route::get('/device-types', [DeviceTypeController::class, 'index'])
                ->name('device-types.index');

            Route::get('/device-types/create', [DeviceTypeController::class, 'create'])
                ->name('device-types.create');

            Route::post('/device-types', [DeviceTypeController::class, 'store'])
                ->name('device-types.store');

            Route::get('/device-types/{deviceType}/edit', [DeviceTypeController::class, 'edit'])
                ->name('device-types.edit');

            Route::put('/device-types/{deviceType}', [DeviceTypeController::class, 'update'])
                ->name('device-types.update');

            Route::delete('/device-types/{deviceType}', [DeviceTypeController::class, 'destroy'])
                ->name('device-types.destroy');


            /*
            |--------------------------------------------------------------------------
            | Estados IP
            |--------------------------------------------------------------------------
            */

            Route::get('/ip-statuses', [IpStatusController::class, 'index'])
                ->name('ip-statuses.index');

            Route::get('/ip-statuses/create', [IpStatusController::class, 'create'])
                ->name('ip-statuses.create');

            Route::post('/ip-statuses', [IpStatusController::class, 'store'])
                ->name('ip-statuses.store');

            Route::get('/ip-statuses/{ipStatus}/edit', [IpStatusController::class, 'edit'])
                ->name('ip-statuses.edit');

            Route::put('/ip-statuses/{ipStatus}', [IpStatusController::class, 'update'])
                ->name('ip-statuses.update');

            Route::delete('/ip-statuses/{ipStatus}', [IpStatusController::class, 'destroy'])
                ->name('ip-statuses.destroy');


            /*
            |--------------------------------------------------------------------------
            | Importador Rangos IP
            |--------------------------------------------------------------------------
            */

            Route::get('/ip-ranges/import', [IpRangeImportController::class, 'create'])
                ->name('ip-ranges.create');

            Route::post('/ip-ranges/import', [IpRangeImportController::class, 'store'])
                ->name('ip-ranges.store');

        });

    });
});


require __DIR__.'/auth.php';
