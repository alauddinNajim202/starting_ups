<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth',

], function ($router) {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::post('/password/request-otp', [AuthController::class, 'requestOtp']);
    Route::post('/password/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);

});
