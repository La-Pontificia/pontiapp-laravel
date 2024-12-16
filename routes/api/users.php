<?php

use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('all', [UserController::class, 'all']);
    Route::get('{slug}/schedules', [UserController::class, 'schedules']);
    Route::get('{slug}/getManager', [UserController::class, 'getManager']);
    Route::get('{slug}/downOrganization', [UserController::class, 'downOrganization']);
    Route::get('{slug}/organization', [UserController::class, 'organization']);

    Route::post('create', [UserController::class, 'create']);
    Route::get('{slug}', [UserController::class, 'one']);
    Route::post('{slug}/manager', [UserController::class, 'manager']);
    Route::post('{slug}/reset-password', [UserController::class, 'resetPassword']);
    Route::post('{slug}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::post('{slug}/updateAccount', [UserController::class, 'updateAccount']);
    Route::post('{slug}/updateOrganization', [UserController::class, 'updateOrganization']);
    Route::post('{slug}/updateProperties', [UserController::class, 'updateProperties']);
    Route::post('{slug}/create-entry-history', [UserController::class, 'createEntryHistory']);

    Route::prefix('notifications')->group(function () {
        Route::get('all', [UserNotificationController::class, 'all']);
    });
});
