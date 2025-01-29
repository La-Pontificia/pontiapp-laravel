<?php

use App\Http\Controllers\Api\Eda\CollaboratorController;
use App\Http\Controllers\Api\Eda\EdaController;
use App\Http\Controllers\Api\Eda\EvaluationController;
use App\Http\Controllers\Api\Eda\ObjetiveController;
use App\Http\Controllers\Api\Eda\YearController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('edas')->group(function () {
        Route::prefix('collaborators')->group(function () {
            Route::get('', [CollaboratorController::class, 'index']);
            Route::get('{slug}', [CollaboratorController::class, 'slug']);
        });
        Route::prefix('years')->group(function () {
            Route::get('', [YearController::class, 'index']);
        });

        Route::prefix('{slug}')->group(function () {
            Route::get('', [EdaController::class, 'slug']);
            Route::post('approve', [EdaController::class, 'approve']);
            Route::post('close', [EdaController::class, 'close']);

            Route::prefix('objetives')->group(function () {
                Route::get('', [ObjetiveController::class, 'byEda']);
                Route::post('store', [ObjetiveController::class, 'storeByEda']);
            });
        });

        Route::prefix('evaluations')->group(function () {
            Route::get('', [EvaluationController::class, 'index']);

            Route::prefix('{slug}')->group(function () {
                Route::get('', [EvaluationController::class, 'slug']);
                Route::post('qualify', [EvaluationController::class, 'qualify']);
                Route::post('selftQualify', [EvaluationController::class, 'selftQualify']);
                Route::post('close', [EvaluationController::class, 'close']);
            });
        });

        Route::get('{slugCollaborator}/{slugYear}', [EdaController::class, 'edaByCollaboratorAndYear']);
        Route::post('{slugCollaborator}/{slugYear}/create', [EdaController::class, 'createEdaByCollaboratorAndYear']);
    });
});
