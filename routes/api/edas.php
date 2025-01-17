<?php

use App\Http\Controllers\Api\Assist\AssistController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('edas')->group(function () {
        Route::get('', [AssistController::class, 'index']);
        Route::get('report', [AssistController::class, 'indexReport']);
    });
});
