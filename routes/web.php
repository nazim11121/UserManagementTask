<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    Route::resource('/users', UserController::class);
    Route::get('users/deleted/list', [UserController::class, 'deletedDataList'])->name('users.deleted-list');
    Route::get('users/deleted/restore/{id}', [UserController::class, 'restore'])->name('users.deleted.restore');
    Route::get('users/deleted/permanently/{id}', [UserController::class, 'forceDelete'])->name('users.deleted.permanently');
    
});

require __DIR__.'/auth.php';
