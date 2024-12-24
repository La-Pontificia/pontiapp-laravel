<?php

use App\Http\Controllers\Api\Global\GlobalController;
use Illuminate\Support\Facades\Route;

Route::prefix('global')->group(function () {
    Route::get('search', [GlobalController::class, 'search']);
});
