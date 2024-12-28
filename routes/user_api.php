<?php

use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\User\Backend\UserAccountController;
use App\Http\Controllers\Api\User\Backend\UserEventController;
use App\Http\Controllers\Api\User\Backend\UserHomeController;
use App\Http\Controllers\Api\User\Backend\UserStoryController;
use Illuminate\Support\Facades\Route;

// Public User API Routes
Route::prefix('user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
});

// Protected User API Routes
Route::middleware(['auth:user', 'role:user'])->prefix('auth-user')->group(function () {
    // Authentication & Profile
    Route::post('refresh', [UserAuthController::class, 'refresh']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('profile', [UserAuthController::class, 'profile']);

    // Password Management
    Route::post('password/request-otp', [UserAuthController::class, 'requestOtp']);
    Route::post('password/verify-otp', [UserAuthController::class, 'verifyOtp']);
    Route::post('password/reset', [UserAuthController::class, 'resetPassword']);

    // Stories
    Route::post('story', [UserStoryController::class, 'store']);
    Route::get('story/{id}', [UserStoryController::class, 'show']);
    Route::post('story/{id}/like', [UserStoryController::class, 'story_like']);
    Route::post('story/{id}/review', [UserStoryController::class, 'story_review']);

    // Events
    Route::post('event/{id}/review', [UserEventController::class, 'event_review']);
    Route::get('event/upcoming', [UserHomeController::class, 'events']);
    Route::get('event/details/{id}', [UserHomeController::class, 'event_details']);

    // Categories
    Route::get('categories', [UserHomeController::class, 'categories']);
    Route::get('categories/{id}/explore-events', [UserHomeController::class, 'explore_event']);

    // Account Management
    Route::get('account/edit', [UserAccountController::class, 'edit']);
    Route::post('account/update', [UserAccountController::class, 'update_profile']);
    Route::get('preferences', [UserAuthController::class, 'preferences']);
    Route::post('preferences', [UserAuthController::class, 'updatePreferences']);
    Route::get('faq', [UserAccountController::class, 'user_faq']);
});
