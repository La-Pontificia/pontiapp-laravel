<?php

use App\Http\Controllers\AssistsController;
use App\Http\Controllers\AssistTerminalController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\EdaController;
use App\Http\Controllers\EventAssistController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\QuestionnaireTemplateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\Api\LoginController as ApiLoginController;


Route::get('auth/login/id', [ApiLoginController::class, 'loginAzure']);
Route::get('auth/login/callback', [ApiLoginController::class, 'callbackAzure']);


Route::post('login', [LoginController::class, 'login']);
// Route::get('login/azure', [LoginController::class, 'redirectToAzure']);
// Route::get('login/azure/callback', [LoginController::class, 'handleAzureCallback']);
Auth::routes();
Route::group(['middleware' => 'authMiddleware'], function () {

    // Home routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    // User roles routes
    Route::get('users/user-roles', [UserRoleController::class, 'index']);

    // Users routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/create', [UserController::class, 'create']);
    Route::get('users/{id}/organization', [UserController::class, 'slug_organization']);
    Route::get('users/{id}/schedules', [UserController::class, 'slug_schedules']);

    Route::get('users/{id}', [UserController::class, 'slug']);

    // Edas routes
    Route::get('edas', [EdaController::class, 'index']);
    Route::get('edas/collaborators', [EdaController::class, 'collaborators']);
    Route::get('edas/reports', [EdaController::class, 'reports']);
    Route::get('edas/years', [YearController::class, 'index']);
    Route::get('edas/questionnaire-templates', [QuestionnaireTemplateController::class, 'index']);
    Route::get('edas/questionnaire-templates/create', [QuestionnaireTemplateController::class, 'create']);
    Route::get('edas/questionnaire-templates/{id}', [QuestionnaireTemplateController::class, 'slug']);

    Route::get('edas/me', [EdaController::class, 'me']);

    Route::get('edas/{id_user}/eda', [EdaController::class, 'user']);
    Route::get('edas/{id_user}/eda/{id_year}', [EdaController::class, 'year']);
    Route::get('edas/{id_user}/eda/{id_year}/goals', [EdaController::class, 'goals']);
    Route::get('edas/{id_user}/eda/{id_year}/evaluation/{id_evaluation}', [EdaController::class, 'evaluation']);
    Route::get('edas/{id_user}/eda/{id_year}/ending', [EdaController::class, 'ending']);
    Route::get('edas/{id_user}/eda/{id_year}/questionnaires', [EdaController::class, 'questionnaires']);

    // Assists routes
    Route::get('assists', [AssistsController::class, 'index']);
    Route::get('assists/centralized-without-calculating', [AssistsController::class, 'centralizedWithoutCalculating']);
    Route::get('assists/without-calculating', [AssistsController::class, 'withoutCalculating']);
    Route::get('assists/single-summary', [AssistsController::class, 'singleSummary']);
    Route::get('assists/terminals', [AssistTerminalController::class, 'index']);


    Route::post('assists/terminals', [AssistTerminalController::class, 'store']);
    Route::post('assists/terminals/{id}', [AssistTerminalController::class, 'update']);
    Route::post('assists/terminals/delete/{id}', [AssistTerminalController::class, 'delete']);

    // -------- SETTINGS ROUTES ---------------------------
    Route::get('settings', [SettingController::class, 'index']);
    Route::get('settings/departments', [DepartmentController::class, 'index']);
    Route::get('settings/job-positions', [JobPositionController::class, 'index']);
    Route::get('settings/roles', [RoleController::class, 'index']);
    Route::get('settings/contract_types', [ContractTypeController::class, 'index']);
    Route::get('settings/branches', [BranchController::class, 'index']);
    Route::get('settings/business-units', [BusinessUnitController::class, 'index']);

    // -------- EVENT ROUTES ---------------------------
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/assists', [EventAssistController::class, 'index']);

    // -------- AUDIT ROUTES ---------------------------
    Route::get('audit', [AuditController::class, 'index']);

    // -------- REPORT ROUTES ---------------------------
    Route::get('reports', [ReportController::class, 'index']);
    Route::get('reports/files', [ReportController::class, 'files']);

    // -------- TICKETS ROUTES ---------------------------
    Route::get('tickets', [TicketController::class, 'index']);
    // Route::get('tickets/pdf', [TicketController::class, 'pdf']);
    Route::get('tickets/create', [TicketController::class, 'create']);
    Route::get('tickets/create/manual', [TicketController::class, 'createManual']);

    Route::get('tickets/tables', [TicketController::class, 'tables']);
    Route::get('tickets/screen', [TicketController::class, 'screen']);
    Route::get('tickets/attentions', [TicketController::class, 'attentions']);

    Route::get('tickets/settings', [TicketController::class, 'settings']);
    Route::get('tickets/settings/modules', [TicketController::class, 'settingsModules']);
    Route::get('tickets/settings/subjects', [TicketController::class, 'settingsSubjects']);
    Route::get('tickets/settings/business-units', [TicketController::class, 'settingsBusinessUnits']);

    // Contract types
    Route::post('contract-types', [ContractTypeController::class, 'store']);
    Route::post('contract-types/{id}', [ContractTypeController::class, 'update']);
    Route::post('contract-types/delete/{id}', [ContractTypeController::class, 'delete']);

    // docs routes

    Route::get('docs/feedbacks/send', [DocsController::class, 'sendFeedback']);
    Route::get('docs/feedbacks/success', [DocsController::class, 'feedbackSuccess']);
    Route::get('docs', [DocsController::class, 'index']);

    // routes if no route is found
    Route::fallback(function () {
        return view('+404');
    });
});
