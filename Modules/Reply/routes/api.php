<?php

use Illuminate\Support\Facades\Route;
use Modules\Reply\Http\Controllers\Api\ReplyController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets.replies', ReplyController::class)->only(['store']);
    Route::apiResource('replies', ReplyController::class)->only(['destroy']);
});
