<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TwoFactorController;

Route::prefix('v1')->group(function () {

    Route::post('/auth/login', [AuthController::class,'login']);
    Route::post('/auth/2fa/verify', [AuthController::class, 'verify2FA']);

    Route::middleware('auth:api')->group(function () {

        Route::apiResource('users', UserController::class);

        Route::post('/conversations', [ConversationController::class, 'store']);
        Route::get('/conversations', [ConversationController::class, 'index']);

        Route::get('/conversations/{id}/messages', [MessageController::class, 'index']);
        Route::post('/messages', [MessageController::class, 'store']);
        Route::post('/typing', [MessageController::class, 'typing']);

        Route::post('/auth/2fa/setup', [TwoFactorController::class, 'setup']);

    });
});
