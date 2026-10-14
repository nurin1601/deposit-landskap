<?php

use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculationController::class, 'index'])->name('calculations.index');
Route::get('/calculations/create', [CalculationController::class, 'create'])->name('calculations.create');
Route::post('/calculations', [CalculationController::class, 'store'])->name('calculations.store');
Route::get('/calculations/{calculation}/edit', [CalculationController::class, 'edit'])->name('calculations.edit');
Route::put('/calculations/{calculation}', [CalculationController::class, 'update'])->name('calculations.update');
Route::post('/calculations/{calculation}/duplicate', [CalculationController::class, 'duplicate'])->name('calculations.duplicate');
Route::get('/calculations/{calculation}', [CalculationController::class, 'show'])->name('calculations.show');
Route::delete('/calculations/{calculation}', [CalculationController::class, 'destroy'])->name('calculations.destroy');