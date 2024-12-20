<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Business\Auth\AuthController;
use App\Http\Controllers\Api\Business\Backend\SubscriptionController;
use App\Http\Controllers\Api\Business\Backend\StripeWebhookController;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth',

], function () {



    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::post('/password/request-otp', [AuthController::class, 'requestOtp']);
    Route::post('/password/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);




    // subscription routes

    Route::get('/subscription/plans',[SubscriptionController::class, 'index']);


    Route::get('/subscription/intent', [SubscriptionController::class, 'createIntent']);
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);

    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);
    Route::get('/subscription/status', [SubscriptionController::class, 'status']);

    Route::post('/subscription/trial', [SubscriptionController::class, 'trial']);
    Route::get('/subscription/trial-status', [SubscriptionController::class, 'trial_status']);

    Route::post('/subscription/webhooks/stripe', [StripeWebhookController::class, 'handle']);



    // business profile routes


});
