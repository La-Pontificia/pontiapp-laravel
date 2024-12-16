<?php

use App\Http\Controllers\Api\Schedule\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('schedules')->group(function () {
    Route::post('', [ScheduleController::class, 'store']);
    Route::post('{id}', [ScheduleController::class, 'update']);
    Route::post('{id}/delete', [ScheduleController::class, 'delete']);
    Route::post('{id}/archive', [ScheduleController::class, 'archive']);
});
