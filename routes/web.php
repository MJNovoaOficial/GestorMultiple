<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\IpStatusController;
use App\Http\Controllers\IpRangeImportController;

Route::get('/', function () {
   
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
    
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    Route::get('/ip-ranges/import', [IpRangeImportController::class, 'create'])
        ->name('ip-ranges.create');

    Route::post('/ip-ranges/import', [IpRangeImportController::class, 'store'])
        ->name('ip-ranges.store');
});


require __DIR__.'/auth.php';
