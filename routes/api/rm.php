<?php

use App\Http\Controllers\Api\Rm\BranchController;
use App\Http\Controllers\Api\Rm\BusinessUnitController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('rm')->group(function () {
        Route::prefix('branches')->group(function () {
            Route::get('', [BranchController::class, 'index']);
            Route::post('', [BranchController::class, 'store']);
            Route::post('{slug}', [BranchController::class, 'update']);
            Route::post('{slug}/delete', [BranchController::class, 'delete']);
        });
        Route::prefix('business-units')->group(function () {
            Route::get('', [BusinessUnitController::class, 'index']);
            Route::post('', [BusinessUnitController::class, 'store']);
            Route::post('{slug}', [BusinessUnitController::class, 'update']);
            Route::post('{slug}/delete', [BusinessUnitController::class, 'delete']);
        });
    });
});
