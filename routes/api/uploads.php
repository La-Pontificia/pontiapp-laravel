<?php

use App\Http\Controllers\Api\Upload\UploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('uploads')->group(function () {
    Route::post('image', [UploadController::class, 'image']);
});
