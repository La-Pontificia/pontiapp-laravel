<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// -------------------------------- AUTH ROUTES ---------------------------

Route::get('login/azure', 'App\Http\Controllers\Auth\LoginController@redirectToAzure')->name('login.azure');
Route::get('login/azure/callback', 'App\Http\Controllers\Auth\LoginController@handleAzureCallback');
Auth::routes();

// -------------------------------- DASHBOARD ROUTES ---------------------------

Route::group(['middleware' => 'authMiddleware'], function () {

    // Home routes
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::get('/home', 'App\Http\Controllers\HomeController@index');

    // Users routes
    Route::get('users', 'App\Http\Controllers\UserController@index')->name('users');
    Route::get('users/create', 'App\Http\Controllers\UserController@create')->name('users.create');
    Route::get('users/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('users.edit');

    // Edas routes
    Route::get('edas', 'App\Http\Controllers\EdaController@index')->name('edas');
    Route::get('edas/surveys', 'App\Http\Controllers\SurveyController@index')->name('edas.surveys');
    Route::get('edas/me', 'App\Http\Controllers\EdaController@me')->name('edas.me');
    Route::get('edas/{id_user}/eda', 'App\Http\Controllers\EdaController@user')->name('edas.user');
    Route::get('edas/{id_user}/eda/{id_year}', 'App\Http\Controllers\EdaController@year')->name('edas.user.year');
    Route::get('edas/{id_user}/eda/{id_year}/goals', 'App\Http\Controllers\EdaController@goals')->name('edas.user.goals');
    Route::get('edas/{id_user}/eda/{id_year}/evaluation/{id_evaluation}', 'App\Http\Controllers\EdaController@evaluation')->name('edas.user.evaluation');
    Route::get('edas/{id_user}/eda/{id_year}/questionnaires', 'App\Http\Controllers\EdaController@questionnaires')->name('edas.user.questionnaires');

    // Assists routes
    Route::get('assists', 'App\Http\Controllers\AssistController@index')->name('assists');

    // Reports routes
    Route::get('reports', 'App\Http\Controllers\ReportController@index')->name('reports');

    // Reports routes
    Route::get('audit', 'App\Http\Controllers\AuditController@index')->name('audit');


    // -------- MAINTAINANCE ROUTES ---------------------------
    // Areas routes
    Route::get('areas', 'App\Http\Controllers\AreaController@index')->name('areas');

    // Departments routes
    Route::get('departments', 'App\Http\Controllers\DepartmentController@index')->name('departments');

    // Job Positions routes
    Route::get('job-positions', 'App\Http\Controllers\JobPositionController@index')->name('job-positions');

    // Roles routes
    Route::get('roles', 'App\Http\Controllers\RoleController@index')->name('roles');

    // Branches routes
    Route::get('branches', 'App\Http\Controllers\BranchController@index')->name('branches');

    // Surveys routes
    Route::get('surveys', 'App\Http\Controllers\SurveyController@index')->name('surveys');

    // Templates routes
    Route::get('templates', 'App\Http\Controllers\TemplateController@index')->name('templates');
    Route::get('templates/create', 'App\Http\Controllers\TemplateController@create')->name('templates.create');
    Route::get('templates/edit/{id}', 'App\Http\Controllers\TemplateController@edit')->name('templates.edit');

    // Years routes
    Route::get('years', 'App\Http\Controllers\YearController@index')->name('years');
});
