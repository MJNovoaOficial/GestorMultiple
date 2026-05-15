<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;

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
});


require __DIR__.'/auth.php';
