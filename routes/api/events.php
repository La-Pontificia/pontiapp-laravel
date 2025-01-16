<?php

use App\Http\Controllers\Api\Event\EventController;
use App\Http\Controllers\Api\Event\EventRecordController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('events')->group(function () {
        Route::prefix('records')->group(function () {
            Route::get('all', [EventRecordController::class, 'index']);
            Route::post('', [EventRecordController::class, 'store']);
            Route::post('report', [EventRecordController::class, 'report']);
            Route::post('{id}/delete', [EventRecordController::class, 'distroy']);
        });

        Route::get('all', [EventController::class, 'all']);
        Route::post('', [EventController::class, 'store']);
        Route::post('{id}/delete', [EventController::class, 'delete']);
        Route::post('{id}', [EventController::class, 'update']);
    });
});
