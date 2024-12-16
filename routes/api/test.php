

<?php

use App\Http\Controllers\Api\Test\TestController;
use Illuminate\Support\Facades\Route;

Route::prefix('tests')->group(function () {
    Route::prefix('websocket')->group(function () {
        Route::post('message', [TestController::class, 'sendMessage']);
    });
});
