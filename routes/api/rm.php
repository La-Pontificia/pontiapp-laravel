<?php

use App\Http\Controllers\Api\Rm\RmAcademicProgramController;
use App\Http\Controllers\Api\Rm\RmAreaController;
use App\Http\Controllers\Api\Rm\RmBranchController;
use App\Http\Controllers\Api\Rm\RmCycleController;
use App\Http\Controllers\Api\Rm\RmRoomController;
use App\Http\Controllers\Api\Rm\RmSectionController;
use App\Http\Controllers\Api\Rm\RmPeriodController;
use App\Http\Controllers\Api\Rm\RmTTrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('rm')->group(function () {
        Route::prefix('periods')->group(function () {
            Route::get('', [RmPeriodController::class, 'index']);
            Route::post('store', [RmPeriodController::class, 'store']);
            Route::post('delete/{id}', [RmPeriodController::class, 'delete']);
        });

        Route::prefix('sections')->group(function () {
            Route::get('', [RmSectionController::class, 'index']);
            Route::post('store', [RmSectionController::class, 'store']);
            Route::post('delete/{id}', [RmSectionController::class, 'delete']);
        });

        Route::prefix('rooms')->group(function () {
            Route::get('', [RmRoomController::class, 'index']);
            Route::post('store', [RmRoomController::class, 'store']);
            Route::post('delete/{id}', [RmRoomController::class, 'delete']);
        });

        Route::prefix('cycles')->group(function () {
            Route::get('', [RmCycleController::class, 'index']);
            Route::post('store', [RmCycleController::class, 'store']);
            Route::post('delete/{id}', [RmCycleController::class, 'delete']);
        });

        Route::prefix('areas')->group(function () {
            Route::get('', [RmAreaController::class, 'index']);
            Route::post('store', [RmAreaController::class, 'store']);
            Route::post('delete/{id}', [RmAreaController::class, 'delete']);
        });

        Route::prefix('academic-programs')->group(function () {
            Route::get('', [RmAcademicProgramController::class, 'index']);
            Route::post('store', [RmAcademicProgramController::class, 'store']);
            Route::post('delete/{id}', [RmAcademicProgramController::class, 'delete']);
        });

        Route::prefix('branches')->group(function () {
            Route::get('', [RmBranchController::class, 'index']);
            Route::post('store', [RmBranchController::class, 'store']);
            Route::post('delete/{id}', [RmBranchController::class, 'delete']);
        });

        Route::prefix('tt')->group(function () {
            Route::get('', [RmTTrackingController::class, 'index']);
            Route::post('store', [RmTTrackingController::class, 'store']);
            Route::post('report', [RmTTrackingController::class, 'report']);
            Route::post('{id}/update', [RmTTrackingController::class, 'update']);
            Route::post('{id}/delete', [RmTTrackingController::class, 'delete']);
            Route::get('{id}', [RmTTrackingController::class, 'one']);
        });
    });
});
