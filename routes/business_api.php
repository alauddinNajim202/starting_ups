<?php

use App\Http\Controllers\Api\Business\Auth\BusinessAuthController;
use App\Http\Controllers\Api\Business\Backend\BusinessProfileController;
use App\Http\Controllers\Api\Business\Backend\EventController;
use App\Http\Controllers\Api\Business\Backend\EventReportController;
use App\Http\Controllers\Api\Business\Backend\SubscriptionController;
use Illuminate\Support\Facades\Route;

// Public Business API Routes
Route::prefix('business')->group(function () {
    Route::post('register', [BusinessAuthController::class, 'register']);
    Route::post('login', [BusinessAuthController::class, 'login']);
});

// Protected Business API Routes
Route::middleware(['auth:business', 'role:business'])->prefix('auth-business')->group(function () {
    // Authentication & Profile
    Route::post('refresh', [BusinessAuthController::class, 'refresh']);
    Route::post('logout', [BusinessAuthController::class, 'logout']);
    Route::get('profile', [BusinessAuthController::class, 'profile']);
    Route::post('profile', [BusinessAuthController::class, 'update_profile']);

    // Password Management
    Route::post('password/request-otp', [BusinessAuthController::class, 'requestOtp']);
    Route::post('password/verify-otp', [BusinessAuthController::class, 'verifyOtp']);
    Route::post('password/reset', [BusinessAuthController::class, 'resetPassword']);

    // Subscription Management
    Route::get('subscription/plans', [SubscriptionController::class, 'index']);

    // Business Profile Management
    Route::post('business-profile/create', [BusinessProfileController::class, 'store']);
    Route::get('business-profile/show', [BusinessProfileController::class, 'business_profile_details']);
    Route::post('business-profile/update', [BusinessProfileController::class, 'business_profile_update']);

    // Events
    Route::post('event/create', [EventController::class, 'store']);
    // Route::post('event/send-invite', [EventController::class, 'send_invite']);




    // events reports
    Route::get('event-reports', [EventReportController::class, 'event_details']);
});
