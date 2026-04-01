<?php

use App\Http\Controllers\CalculationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculationController::class, 'index'])->name('home');
Route::post('/calculate', [CalculationController::class, 'store'])->name('calculate.store');
Route::get('/result/{calculation}', [CalculationController::class, 'result'])->name('result');
Route::get('/history', [CalculationController::class, 'history'])->name('history');
Route::get('/export/pdf/{calculation}', [CalculationController::class, 'exportPdf'])->name('export.pdf');
Route::delete('/destroy/{calculation}', [CalculationController::class, 'destroy'])->name('destroy');
