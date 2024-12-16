<?php

use App\Http\Controllers\Api\Attention\AttentionPositionController;
use App\Http\Controllers\Api\Attention\AttentionServiceController;
use App\Http\Controllers\Api\Attention\AttentionTicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('attentions')->group(function () {
    Route::prefix('positions')->group(function () {
        Route::get('all', [AttentionPositionController::class, 'all']);
        Route::post('', [AttentionPositionController::class, 'store']);
        Route::post('{id}', [AttentionPositionController::class, 'update']);
        Route::post('{id}/delete', [AttentionPositionController::class, 'delete']);
    });

    Route::prefix('services')->group(function () {
        Route::get('all', [AttentionServiceController::class, 'all']);
        Route::post('', [AttentionServiceController::class, 'store']);
        Route::post('{id}', [AttentionServiceController::class, 'update']);
        Route::post('{id}/delete', [AttentionServiceController::class, 'delete']);
        Route::get('business/{businessId}', [AttentionServiceController::class, 'byBusiness']);
    });

    Route::prefix('tickets')->group(function () {
        Route::post('', [AttentionTicketController::class, 'store']);
        Route::get('all', [AttentionTicketController::class, 'all']);
    });
});
