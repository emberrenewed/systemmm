<?php

use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\Api\TicketController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class);
});
