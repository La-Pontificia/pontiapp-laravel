<?php

use App\Http\Controllers\Api\ToolController;
use Illuminate\Support\Facades\Route;

Route::prefix('tools')->group(function () {
    Route::middleware('check.auth')->group(function () {
        Route::post('synchronize/{slug}', [ToolController::class, 'syncTerminalEmployee']);
    });
    Route::get('downloadReportFile/{id}', [ToolController::class, 'downloadReportFile']);
});
