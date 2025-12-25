<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
Route::get('/', [PageController::class, 'showHomepage']);
Route::get('/about', [PageController::class, 'showHomepage']); 
// Gợi ý:
use App\Http\Controllers\SinhVienController;
Route::get('/sinhvien', [SinhVienController::class, 'index'])->name('sinhvien.index');
Route::post('/sinhvien', [SinhVienController::class, 'store'])->name('sinhvien.store'); 