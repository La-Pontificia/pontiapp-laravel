<?php

use App\Http\Controllers\Api\User\ScheduleController;
use App\Http\Controllers\Api\User\SessionController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserNotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('all', [UserController::class, 'all']);
        Route::get('search', [UserController::class, 'search']);

        Route::post('create', [UserController::class, 'create']);
        Route::get('indexUsers', [UserController::class, 'indexUsers']);

        Route::prefix('schedules')->group(function () {
            Route::post('', [ScheduleController::class, 'store']);
            Route::post('{id}', [ScheduleController::class, 'update']);
            Route::post('{id}/delete', [ScheduleController::class, 'delete']);
            Route::post('{id}/archive', [ScheduleController::class, 'archive']);
            Route::get('{slug}', [ScheduleController::class, 'index']);
        });

        Route::prefix('notifications')->group(function () {
            Route::get('all', [UserNotificationController::class, 'all']);
        });

        Route::prefix('sessions')->group(function () {
            Route::get('', [SessionController::class, 'index']);
            Route::post('{id}/delete', [SessionController::class, 'delete']);
        });

        Route::prefix('{slug}')->group(function () {
            Route::get('', [UserController::class, 'one']);
            Route::get('edit', [UserController::class, 'oneEdit']);
            Route::get('sessions', [UserController::class, 'sessions']);
            Route::get('getManager', [UserController::class, 'getManager']);
            Route::get('downOrganization', [UserController::class, 'downOrganization']);
            Route::get('organization', [UserController::class, 'organization']);
            Route::get('getProperties', [UserController::class, 'getProperties']);
            Route::get('getPropertiesEdit', [UserController::class, 'getPropertiesEdit']);
            Route::get('getAccount', [UserController::class, 'getAccount']);
            Route::get('getOrganization', [UserController::class, 'getOrganization']);

            Route::post('', [UserController::class, 'update']);
            Route::post('manager', [UserController::class, 'manager']);
            Route::post('reset-password', [UserController::class, 'resetPassword']);
            Route::post('toggle-status', [UserController::class, 'toggleStatus']);
            Route::post('updateAccount', [UserController::class, 'updateAccount']);
            Route::post('updateOrganization', [UserController::class, 'updateOrganization']);
            Route::post('updateProperties', [UserController::class, 'updateProperties']);
            Route::post('create-entry-history', [UserController::class, 'createEntryHistory']);
            Route::post('update-profile-photo', [UserController::class, 'updateProfilePhoto']);
        });
    });
});
