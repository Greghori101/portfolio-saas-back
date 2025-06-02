<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('portfolios', PortfolioController::class);
});
