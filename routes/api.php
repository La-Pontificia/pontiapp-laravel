<?php

use App\Http\Controllers\Api\EdaController;
use App\Http\Controllers\EdaController as ControllersEdaController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\GoalController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionnaireTemplateController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\UserController as ControllersUserController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssistsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {



    // Users routes
    Route::post('users', [UserController::class, 'create']);
    Route::get('users/export', [ControllersUserController::class, 'export']);
    Route::get('users/export-email-access', [ControllersUserController::class, 'exportEmailAccess']);

    Route::get('users/search', [UserController::class, 'search']);
    Route::post('users/email-access/{id}', [UserController::class, 'updateEmailAccess']);
    Route::get('users/supervisor/{id}/search', [UserController::class, 'searchSupervisor']);
    Route::post('users/supervisor/remove/{id}', [UserController::class, 'removeSupervisor']);
    Route::post('users/supervisor/assign/{id}', [UserController::class, 'assignSupervisor']);
    Route::post('users/reset-password/{id}', [UserController::class, 'resetPassword']);
    Route::post('users/change-password/{id}', [UserController::class, 'changePassword']);
    Route::post('users/toggle-status/{id}', [UserController::class, 'toggleStatus']);

    // User slug routes
    Route::post('users/{id}/organization', [UserController::class, 'updateOrganization']);
    Route::post('users/{id}/details', [UserController::class, 'updateDetails']);
    Route::post('users/{id}/segurity-access', [UserController::class, 'updateSegurityAccess']);
    Route::post('users/{id}/rol-privileges', [UserController::class, 'updateRolPrivileges']);
    Route::post('users/{id}/profile', [UserController::class, 'profile']);

    // User user roles routes 
    Route::post('user-roles', [UserRoleController::class, 'create']);
    Route::post('user-roles/{id}', [UserRoleController::class, 'update']);
    Route::post('user-roles/delete/{id}', [UserRoleController::class, 'delete']);

    // Cargo routes
    Route::get('roles/by_job_position/{id}', [RolController::class, 'by_job_position']);

    // Edas routes
    Route::post('edas/create/{year_id}/user/{user_id}', [EdaController::class, 'create']);
    Route::post('edas/create-independent', [EdaController::class, 'createIndependent']);
    Route::post('edas/{id}/close', [EdaController::class, 'close']);
    Route::post('edas/{id}/restart', [EdaController::class, 'restart']);
    Route::post('edas/{id}/questionnaire', [EdaController::class, 'questionnaire']);
    Route::get('edas/export', [ControllersEdaController::class, 'export']);


    // Goals routes
    Route::post('edas/{id}/goals/sent', [GoalController::class, 'sent']);
    Route::post('edas/{id}/goals/update', [GoalController::class, 'update']);
    Route::post('edas/{id}/goals/approve', [GoalController::class, 'approve']);
    Route::get('edas/{id}/goals', [GoalController::class, 'byEda']);
    Route::get('edas/{id}/goals/evaluations', [GoalController::class, 'evaluations']);

    // evaluations routes
    Route::post('evaluations/self-qualify/{id}', [EvaluationController::class, 'selfqualify']);
    Route::post('evaluations/qualify/{id}', [EvaluationController::class, 'qualify']);
    Route::post('evaluations/close/{id}', [EvaluationController::class, 'close']);
    Route::post('evaluations/{id}/feedback/send', [EvaluationController::class, 'feedback']);
    Route::post('evaluations/{id}/feedback/read', [EvaluationController::class, 'readFeedback']);

    // Areas routes
    Route::post('areas', [AreaController::class, 'store']);
    Route::post('areas/{id}', [AreaController::class, 'update']);
    Route::post('areas/delete/{id}', [AreaController::class, 'delete']);

    // Departments routes
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::post('departments/{id}', [DepartmentController::class, 'update']);
    Route::post('departments/delete/{id}', [DepartmentController::class, 'delete']);


    // Job Positions routes
    Route::post('job-positions', [JobPositionController::class, 'store']);
    Route::post('job-positions/{id}', [JobPositionController::class, 'update']);
    Route::post('job-positions/delete/{id}', [JobPositionController::class, 'delete']);

    // Roles routes
    Route::post('roles', [RoleController::class, 'store']);
    Route::post('roles/{id}', [RoleController::class, 'update']);
    Route::post('roles/delete/{id}', [RoleController::class, 'delete']);

    // Branches routes
    Route::post('branches', [BranchController::class, 'store']);
    Route::post('branches/{id}', [BranchController::class, 'update']);
    Route::post('branches/delete/{id}', [BranchController::class, 'delete']);

    // Business Unit
    Route::post('business-units', [BusinessUnitController::class, 'store']);
    Route::post('business-units/{id}', [BusinessUnitController::class, 'updated']);
    Route::post('business-units/delete/{id}', [BusinessUnitController::class, 'delete']);

    // Template routes
    Route::post('questionnaire-templates', [QuestionnaireTemplateController::class, 'create']);
    Route::post('questionnaire-templates/{id}', [QuestionnaireTemplateController::class, 'update']);
    Route::post('questionnaire-templates/{id}/use', [QuestionnaireTemplateController::class, 'use']);
    Route::post('questionnaire-templates/{id}/archive', [QuestionnaireTemplateController::class, 'archive']);
    Route::post('questionnaire-templates/{id}/delete', [QuestionnaireTemplateController::class, 'delete']);
    Route::post('questionnaire-templates/{id}/use/{for}', [QuestionnaireTemplateController::class, 'use']);

    // assists routes

    Route::get('assists/export', [AssistsController::class, 'peerScheduleExport']);
    Route::get('assists/peer-user/{id}/export', [AssistsController::class, 'peerUserExport']);
    Route::get('assists/centralized/export', [AssistsController::class, 'centralizedExport']);

    // Questions routes
    Route::get('questionnaire-templates/{id}/questions', [QuestionController::class, 'questions']);

    // years routes
    Route::post('years', [YearController::class, 'create']);
    Route::post('years/{id}', [YearController::class, 'update']);
    Route::post('years/open/{id}', [YearController::class, 'open']);
    Route::post('years/close/{id}', [YearController::class, 'close']);
    Route::post('years/delete/{id}', [YearController::class, 'delete']);

    // Schedules routes
    Route::post('schedules/delete/{id}', [ScheduleController::class, 'remove']);
    Route::post('schedules/archive/{id}', [ScheduleController::class, 'archive']);

    Route::get('schedules/group/{id}', [ScheduleController::class, 'groupSchedules']);
    Route::post('schedules/group/default/{id}', [ScheduleController::class, 'groupDefault']);
    Route::post('schedules/group', [ScheduleController::class, 'group']);
    Route::post('schedules/group/{id}', [ScheduleController::class, 'groupUpdate']);
    Route::post('schedules/group/delete/{id}', [ScheduleController::class, 'groupDelete']);
    Route::post('schedules/group/{id}/add', [ScheduleController::class, 'add']);

    Route::post('schedules/{id}', [ScheduleController::class, 'update']);
    Route::get('schedules/user/{id}', [ScheduleController::class, 'by_user']);
});
