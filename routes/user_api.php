<?php

use App\Http\Controllers\Api\User\Auth\UserAuthController;
use App\Http\Controllers\Api\User\Backend\UserAccountController;
use App\Http\Controllers\Api\User\Backend\UserEventController;
use App\Http\Controllers\Api\User\Backend\UserHomeController;
use App\Http\Controllers\Api\User\Backend\UserStoryController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('user-register', [UserAuthController::class, 'register']);
Route::post('user-login', [UserAuthController::class, 'login']);

// Protected routes

Route::group([
    'middleware' => ['auth:user', 'role:user'],
    'prefix' => 'auth',

], function () {

    Route::post('/refresh', [UserAuthController::class, 'refresh']);
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('user-profile', [UserAuthController::class, 'profile']);

    Route::post('/user-password/request-otp', [UserAuthController::class, 'requestOtp']);
    Route::post('/user-password/verify-otp', [UserAuthController::class, 'verifyOtp']);
    Route::post('/user-password/reset', [UserAuthController::class, 'resetPassword']);

    // user stories
    Route::post('/user-story', [UserStoryController::class, 'store']);

    Route::get('/user-story/{id}', [UserStoryController::class, 'show']);

    //  like story
    Route::post('/user-story/{id}/like', [UserStoryController::class, 'story_like']);

    // __user story comment
    Route::post('/user-story/{id}/review', [UserStoryController::class, 'story_review']);

    // __user event reviews
    Route::post('/event/{id}/review', [UserEventController::class, 'event_review']);




    // __user home routes
    Route::get('/categories', [UserHomeController::class, 'categories']);
    Route::get('/upcoming-events', [UserHomeController::class, 'events']);




    // __user account routes
    Route::get('/user/profile-edit', [UserAccountController::class, 'edit']);
    Route::post('/user/profile-update', [UserAccountController::class, 'update_profile']);
    // get user preferences
    Route::get('user-preferences', [UserAuthController::class, 'preferences']);
    // update user preferences
    Route::post('user-preferences', [UserAuthController::class, 'updatePreferences']);
    // __user faq
    Route::get('/faq', [UserAccountController::class, 'user_faq']);

});
