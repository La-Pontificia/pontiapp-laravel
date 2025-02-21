<?php

use App\Http\Controllers\Api\Rm\RmAcademicAreaController;
use App\Http\Controllers\Api\Rm\RmAcademicProgramController;
use App\Http\Controllers\Api\Rm\RmBranchController;
use App\Http\Controllers\Api\Rm\RmClassroomController;
use App\Http\Controllers\Api\Rm\RmCycleController;
use App\Http\Controllers\Api\Rm\RmSectionController;
use App\Http\Controllers\Api\Rm\RmPeriodController;
use App\Http\Controllers\Api\Rm\RmTTrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('rm')->group(function () {
        Route::prefix('periods')->group(function () {
            Route::get('', [RmPeriodController::class, 'index']);
            Route::post('', [RmPeriodController::class, 'store']);
            Route::post('{slug}', [RmPeriodController::class, 'update']);
            Route::post('{slug}/delete', [RmPeriodController::class, 'delete']);
        });

        Route::prefix('sections')->group(function () {
            Route::get('', [RmSectionController::class, 'index']);
            Route::post('', [RmSectionController::class, 'store']);
            Route::post('{slug}', [RmSectionController::class, 'update']);
            Route::post('{slug}/delete', [RmSectionController::class, 'delete']);
        });

        Route::prefix('classrooms')->group(function () {
            Route::get('', [RmClassroomController::class, 'index']);
            Route::post('', [RmClassroomController::class, 'store']);
            Route::post('{slug}', [RmClassroomController::class, 'update']);
            Route::post('{slug}/delete', [RmClassroomController::class, 'delete']);
        });

        Route::prefix('cycles')->group(function () {
            Route::get('', [RmCycleController::class, 'index']);
            Route::post('', [RmCycleController::class, 'store']);
            Route::post('{slug}', [RmCycleController::class, 'update']);
            Route::post('{slug}/delete', [RmCycleController::class, 'delete']);
        });

        Route::prefix('academic-areas')->group(function () {
            Route::get('', [RmAcademicAreaController::class, 'index']);
            Route::post('', [RmAcademicAreaController::class, 'store']);
            Route::post('{slug}', [RmAcademicAreaController::class, 'update']);
            Route::post('{slug}/delete', [RmAcademicAreaController::class, 'delete']);
        });

        Route::prefix('academic-programs')->group(function () {
            Route::get('', [RmAcademicProgramController::class, 'index']);
            Route::post('', [RmAcademicProgramController::class, 'store']);
            Route::post('{slug}', [RmAcademicProgramController::class, 'update']);
            Route::post('{slug}/delete', [RmAcademicProgramController::class, 'delete']);
        });

        Route::prefix('branches')->group(function () {
            Route::get('', [RmBranchController::class, 'index']);
            Route::post('', [RmBranchController::class, 'store']);
            Route::post('{slug}', [RmBranchController::class, 'update']);
            Route::post('{slug}/delete', [RmBranchController::class, 'delete']);
        });

        Route::prefix('tt')->group(function () {
            Route::get('', [RmTTrackingController::class, 'index']);
            Route::post('store', [RmTTrackingController::class, 'store']);
            Route::post('report', [RmTTrackingController::class, 'report']);
            Route::post('{slug}', [RmTTrackingController::class, 'update']);
            Route::post('{slug}/delete', [RmTTrackingController::class, 'delete']);
            Route::get('{slug}', [RmTTrackingController::class, 'one']);
        });
    });
});
