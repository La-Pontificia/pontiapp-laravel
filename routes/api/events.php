<?php

use App\Http\Controllers\Api\Event\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('events')->group(function () {
    Route::prefix('records')->group(function () {
        Route::get('all', [EventController::class, 'allRecords']);
    });

    Route::get('all', [EventController::class, 'all']);
    Route::post('', [EventController::class, 'store']);
    Route::post('{id}/delete', [EventController::class, 'delete']);
    Route::post('{id}', [EventController::class, 'update']);
});
