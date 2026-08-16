<?php

use Illuminate\Support\Facades\Route;
use Modules\Reply\Http\Controllers\Web\ReplyController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/replies', [ReplyController::class, 'index'])->name('replies.index');
    Route::post('/tickets/{ticket}/replies', [ReplyController::class, 'store'])->name('replies.store');
});
