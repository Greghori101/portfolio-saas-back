<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ConsumptionController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\PortfolioController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\ThemesController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::apiResource('plans', PlanController::class);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('portfolios', PortfolioController::class);
        Route::apiResource('themes', ThemesController::class);
        Route::apiResource('subscriptions', SubscriptionController::class);
        Route::apiResource('consumptions', ConsumptionController::class);

    });
});
