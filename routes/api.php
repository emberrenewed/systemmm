<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('tickets.replies', ReplyController::class)->only(['store']);
    Route::apiResource('replies', ReplyController::class)->only(['destroy']);
});









// Route::get('/tickets', [TicketController::class, 'index']);
    // Route::post('/tickets', [TicketController::class, 'store']);
  // Route::post('/tickets/{ticket}/replies', [ReplyController::class, 'store']);
    // Route::delete('/replies/{reply}', [ReplyController::class, 'destroy']);
        // Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    // Route::patch('/tickets/{ticket}', [TicketController::class, 'update']);
    // Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);