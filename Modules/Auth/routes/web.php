<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Web\LoginController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
