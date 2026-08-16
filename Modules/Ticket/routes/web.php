<?php

use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\Web\TicketController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    Route::apiResource('tickets', TicketController::class)->only(['index', 'show', 'update']);
});
