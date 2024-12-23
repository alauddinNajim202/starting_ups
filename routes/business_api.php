<?php

use App\Http\Controllers\Api\Business\Auth\BusinessAuthController;
use App\Http\Controllers\Api\Business\Backend\BusinessProfileController;
use App\Http\Controllers\Api\Business\Backend\EventController;
use App\Http\Controllers\Api\Business\Backend\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [BusinessAuthController::class, 'register']);
Route::post('login', [BusinessAuthController::class, 'login']);

// Protected routes

Route::group([
    'middleware' => ['auth:business', 'role:business'],
    'prefix' => 'auth',

], function () {

    Route::post('/refresh', [BusinessAuthController::class, 'refresh']);
    Route::post('logout', [BusinessAuthController::class, 'logout']);


    Route::get('profile', [BusinessAuthController::class, 'profile']);
    Route::get('profile-edit', [BusinessAuthController::class, 'edit']);
    Route::post('profile-update', [BusinessAuthController::class, 'update_profile']);



    Route::post('/password/request-otp', [BusinessAuthController::class, 'requestOtp']);
    Route::post('/password/verify-otp', [BusinessAuthController::class, 'verifyOtp']);
    Route::post('/password/reset', [BusinessAuthController::class, 'resetPassword']);

    // subscription routes

    Route::get('/subscription/plans', [SubscriptionController::class, 'index']);

    // Route::get('/subscription/intent', [SubscriptionController::class, 'createIntent']);
    // Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe']);

    // Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']);
    // Route::get('/subscription/status', [SubscriptionController::class, 'status']);

    // Route::post('/subscription/trial', [SubscriptionController::class, 'trial']);
    // Route::get('/subscription/trial-status', [SubscriptionController::class, 'trial_status']);

    // Route::post('/subscription/webhooks/stripe', [StripeWebhookController::class, 'handle']);




    // business profile routes
    Route::post('/business/profile-create', [BusinessProfileController::class, 'store']);
    Route::get('/business/profile-details', [BusinessProfileController::class, 'business_profile_details']);
    Route::post('/business/profile-update', [BusinessProfileController::class, 'update']);









    // event routes
    Route::post('/business/event-create', [EventController::class, 'store']);

    Route::post('business/send-invite', [EventController::class, 'send_invite']);

});
