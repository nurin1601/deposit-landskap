<?php

use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

// Homepage (terbuka kepada semua)
Route::get('/', fn () => view('home'))->name('home');

// Perlu log masuk
Route::middleware('auth')->group(function () {

    // Breeze hantar pengguna ke sini selepas log masuk
    Route::get('/dashboard', fn () => redirect()->route('calculations.index'))->name('dashboard');

    // Calculations
    Route::get('/calculations', [CalculationController::class, 'index'])->name('calculations.index');
    Route::get('/calculations/create', [CalculationController::class, 'create'])->name('calculations.create');
    Route::post('/calculations', [CalculationController::class, 'store'])->name('calculations.store');
    Route::get('/calculations/{calculation}/edit', [CalculationController::class, 'edit'])->name('calculations.edit');
    Route::put('/calculations/{calculation}', [CalculationController::class, 'update'])->name('calculations.update');
    Route::post('/calculations/{calculation}/duplicate', [CalculationController::class, 'duplicate'])->name('calculations.duplicate');
    Route::get('/calculations/{calculation}', [CalculationController::class, 'show'])->name('calculations.show');
    Route::delete('/calculations/{calculation}', [CalculationController::class, 'destroy'])->name('calculations.destroy');
});

// Log masuk dan log keluar (Breeze)
require __DIR__.'/auth.php';