<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\AzureController;
use App\Http\Controllers\Api\Auth\SanctumController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::middleware('web')->group(function () {
        Route::get('login/id', [AzureController::class, 'login']);
        Route::get('azure/callback', [AzureController::class, 'callback']);
        Route::post('login/credentials', [AuthController::class, 'credentials']);
    });

    Route::get('current', [AuthController::class, 'current']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('signout', [AuthController::class, 'signOut']);
    Route::post('update-profile-photo', [AuthController::class, 'changeProfile']);
    Route::get('sanctum/csrf-cookie', [SanctumController::class, 'csrfCookie']);
});
