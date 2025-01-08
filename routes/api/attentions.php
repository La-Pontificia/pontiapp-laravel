<?php

use App\Http\Controllers\Api\Attention\AttentionBusinessUnitController;
use App\Http\Controllers\Api\Attention\AttentionController;
use App\Http\Controllers\Api\Attention\AttentionPositionController;
use App\Http\Controllers\Api\Attention\AttentionServiceController;
use App\Http\Controllers\Api\Attention\AttentionTicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('attentions')->group(function () {
    Route::post('', [AttentionController::class, 'store']);
    Route::get('', [AttentionController::class, 'index']);
    Route::post('{id}', [AttentionController::class, 'update']);
    Route::post('{id}/delete', [AttentionController::class, 'destroy']);

    Route::prefix('positions')->group(function () {
        Route::get('all', [AttentionPositionController::class, 'all']);
        Route::post('', [AttentionPositionController::class, 'store']);
        Route::post('{id}', [AttentionPositionController::class, 'update']);
        Route::post('{id}/delete', [AttentionPositionController::class, 'delete']);
        Route::post('{id}/ui', [AttentionPositionController::class, 'updateUi']);
    });

    Route::prefix('services')->group(function () {
        Route::get('all', [AttentionServiceController::class, 'all']);
        Route::post('', [AttentionServiceController::class, 'store']);
        Route::post('{id}', [AttentionServiceController::class, 'update']);
        Route::post('{id}/delete', [AttentionServiceController::class, 'delete']);
        Route::get('', [AttentionServiceController::class, 'byBusinesses']);
    });

    Route::prefix('tickets')->group(function () {
        Route::post('', [AttentionTicketController::class, 'store']);
        Route::get('all', [AttentionTicketController::class, 'all']);
        Route::post('{id}/delete', [AttentionTicketController::class, 'delete']);
    });

    Route::prefix('businessUnits')->group(function () {
        Route::get('', [AttentionBusinessUnitController::class, 'index']);
        Route::post('', [AttentionBusinessUnitController::class, 'store']);
    });
});
