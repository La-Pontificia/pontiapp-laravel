<?php

use App\Http\Controllers\Api\ToolController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('tools')->group(function () {
        Route::post('synchronize/{slug}', [ToolController::class, 'syncTerminalEmployee']);
    });
});
