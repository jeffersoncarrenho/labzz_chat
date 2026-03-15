<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;

Route::prefix('v1')->group(function () {

    Route::post('/conversations', [ConversationController::class, 'store']);

    Route::get('/conversations', [ConversationController::class, 'index']);

    Route::get('/conversations/{id}/messages', [MessageController::class, 'index']);

    Route::post('/messages', [MessageController::class, 'store']);

    Route::post('/typing', [MessageController::class, 'typing']);

});
