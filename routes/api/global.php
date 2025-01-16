<?php

use App\Http\Controllers\Api\Global\GlobalController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('global')->group(function () {
        Route::get('search', [GlobalController::class, 'search']);
    });
});
