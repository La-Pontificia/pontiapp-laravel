<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// -------------------------------- AUTH ROUTES ---------------------------

Route::post('login', 'App\Http\Controllers\Api\LoginController@close');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Users routes
    Route::post('users', 'App\Http\Controllers\Api\UserController@create');
    Route::post('users/{id}', 'App\Http\Controllers\Api\UserController@edit');
    Route::get('users/search', 'App\Http\Controllers\Api\UserController@search');

    // Cargo routes
    Route::get('roles/by_job_position/{id}', 'App\Http\Controllers\Api\RolController@by_job_position');

    // Edas routes
    Route::post('edas', 'App\Http\Controllers\Api\EdaController@create');

    // Goals routes
    Route::post('goals/sent', 'App\Http\Controllers\Api\GoalController@sent');
    Route::post('goals/approve', 'App\Http\Controllers\Api\GoalController@approve');
    Route::post('goals/update/{id}', 'App\Http\Controllers\Api\GoalController@update');
    Route::get('goals/by-eda/{id}', 'App\Http\Controllers\Api\GoalController@byEda');
    Route::get('goals/by-evaluation/{id}', 'App\Http\Controllers\Api\GoalController@byEvaluation');

    // evaluations routes
    Route::post('evaluation/self-qualification', 'App\Http\Controllers\Api\EvaluationController@selfQualification');
    Route::post('evaluation/average', 'App\Http\Controllers\Api\EvaluationController@average');
    Route::post('evaluation/close', 'App\Http\Controllers\Api\EvaluationController@close');

    // Areas routes
    Route::post('areas', 'App\Http\Controllers\AreaController@store');
    Route::post('areas/{id}', 'App\Http\Controllers\AreaController@update');

    // Departments routes
    Route::post('departments', 'App\Http\Controllers\DepartmentController@store');
    Route::post('departments/{id}', 'App\Http\Controllers\DepartmentController@update');

    // Job Positions routes
    Route::post('job-positions', 'App\Http\Controllers\JobPositionController@store');
    Route::post('job-positions/{id}', 'App\Http\Controllers\JobPositionController@update');

    // Roles routes
    Route::post('roles', 'App\Http\Controllers\RoleController@store');
    Route::post('roles/{id}', 'App\Http\Controllers\RoleController@update');

    // Branches routes
    Route::post('branches', 'App\Http\Controllers\BranchController@store');
    Route::post('branches/{id}', 'App\Http\Controllers\BranchController@update');
});
