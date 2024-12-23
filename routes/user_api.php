<?php

use App\Http\Controllers\Api\User\Auth\UserAuthController;


use Illuminate\Support\Facades\Route;

// Public routes
Route::post('user-register', [UserAuthController::class, 'register']);
Route::post('user-login', [UserAuthController::class, 'login']);

// Protected routes

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth',

], function () {

    Route::post('/refresh', [UserAuthController::class, 'refresh']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('user-profile', [UserAuthController::class, 'profile']);

    // get user preferences
    Route::get('user-preferences', [UserAuthController::class, 'preferences']);
    // update user preferences
    Route::post('user-preferences', [UserAuthController::class, 'updatePreferences']);

    Route::post('/user-password/request-otp', [UserAuthController::class, 'requestOtp']);
    Route::post('/user-password/verify-otp', [UserAuthController::class, 'verifyOtp']);
    Route::post('/user-password/reset', [UserAuthController::class, 'resetPassword']);



});
