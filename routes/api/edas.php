<?php

use App\Http\Controllers\Api\Eda\EdaController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('edas')->group(function () {
        Route::get('collaborators', [EdaController::class, 'collaborators']);
    });
});
