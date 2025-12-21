<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\User\AuthController;

Route::middleware(['api', 'set-locale'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});
