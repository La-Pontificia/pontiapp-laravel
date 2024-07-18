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

    // Module routes
    Route::get('/', 'App\Http\Controllers\ModuleController@index')->name('modules');

    // User roles routes
    Route::get('users/user-roles', 'App\Http\Controllers\UserRoleController@index')->name('users.user-roles');
    Route::get('users/user-roles/create', 'App\Http\Controllers\UserRoleController@create')->name('users.user-roles.create');
    Route::get('users/user-roles/{id}', 'App\Http\Controllers\UserRoleController@slug')->name('users.user-roles.slug');

    // Users routes
    Route::get('users', 'App\Http\Controllers\UserController@index')->name('users');

    Route::get('users/schedules', 'App\Http\Controllers\ScheduleController@index')->name('users.schedules');
    Route::get('users/schedules/create', 'App\Http\Controllers\ScheduleController@create')->name('users.schedules.create');
    Route::get('users/schedules/{id}', 'App\Http\Controllers\ScheduleController@schedule')->name('users.schedules.schedule');

    Route::get('users/emails', 'App\Http\Controllers\UserController@emails')->name('users.emails');

    Route::get('users/domains', 'App\Http\Controllers\UserController@domains')->name('users.domains');

    Route::get('users/sessions', 'App\Http\Controllers\UserController@sessions')->name('users.sessions');

    Route::get('users/job-positions', 'App\Http\Controllers\UserController@jobPositions')->name('users.job-positions');

    Route::get('users/roles', 'App\Http\Controllers\UserController@roles')->name('users.job-positions');

    Route::get('users/create', 'App\Http\Controllers\UserController@create')->name('users.create');
    Route::get('users/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('users.edit');

    Route::get('users/{id}', 'App\Http\Controllers\UserController@slug')->name('users.slug');
    Route::get('users/{id}/organization', 'App\Http\Controllers\UserController@slug_organization')->name('users.slug.organization');
    Route::get('users/{id}/schedules', 'App\Http\Controllers\UserController@slug_schedules')->name('users.slug.schedules');
    Route::get('users/{id}/attendance', 'App\Http\Controllers\UserController@slug_attendance')->name('users.slug.attendance');


    // Edas routes
    Route::get('edas', 'App\Http\Controllers\EdaController@index')->name('edas');
    // Route::get('edas/surveys', 'App\Http\Controllers\SurveyController@index')->name('edas.surveys');
    Route::get('edas/me', 'App\Http\Controllers\EdaController@me')->name('edas.me');

    Route::get('edas/{id_user}/eda', 'App\Http\Controllers\EdaController@user')->name('edas.slug');
    Route::get('edas/{id_user}/eda/{id_year}', 'App\Http\Controllers\EdaController@year')->name('edas.slug.year');
    Route::get('edas/{id_user}/eda/{id_year}/goals', 'App\Http\Controllers\EdaController@goals')->name('edas.slug.goals');
    Route::get('edas/{id_user}/eda/{id_year}/evaluation/{id_evaluation}', 'App\Http\Controllers\EdaController@evaluation')->name('edas.slug.evaluation');
    Route::get('edas/{id_user}/eda/{id_year}/questionnaires', 'App\Http\Controllers\EdaController@questionnaires')->name('edas.slug.questionnaires');

    // Assists routes
    Route::get('assists', 'App\Http\Controllers\AssistController@index')->name('assists');
    Route::get('assists/{id_user}', 'App\Http\Controllers\AssistController@user')->name('assists.user');
    Route::get('assists/{id_user}/schedules', 'App\Http\Controllers\AssistController@user')->name('assists.user.schedules');
    Route::get('assists/schedules', 'App\Http\Controllers\AssistController@schedules')->name('assists.schedules');

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
