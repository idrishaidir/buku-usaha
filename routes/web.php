<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/transactions', [TransactionController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('transactions.store');

Route::get('/dashboard', [TransactionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('transactions.edit');

Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('transactions.update');

Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('transactions.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
