<?php

use App\Http\Controllers\Api\Rm\BranchController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('rm')->group(function () {
        Route::prefix('branches')->group(function () {
            Route::get('', [BranchController::class, 'index']);
            Route::post('', [BranchController::class, 'store']);
            Route::post('{slug}', [BranchController::class, 'update']);
            Route::post('{slug}/delete', [BranchController::class, 'delete']);
        });
    });
});
