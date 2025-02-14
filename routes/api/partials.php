<?php

use App\Http\Controllers\Api\Area\AreaController;
use App\Http\Controllers\Api\ContractType\ContractTypeController;
use App\Http\Controllers\Api\Job\JobController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\AssistTerminal\AssistTerminalController;
use App\Http\Controllers\Api\BusinessUnit\BusinessUnitController;
use App\Http\Controllers\Api\Department\DepartmentController;
use App\Http\Controllers\Api\Report\ReportController;
use App\Http\Controllers\Api\UserRole\UserRoleController;
use App\Http\Controllers\Api\UserTeam\UserTeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('partials')->group(function () {

        Route::prefix('assist-terminals')->group(function () {
            Route::get('all', [AssistTerminalController::class, 'all']);
            Route::post('', [AssistTerminalController::class, 'store']);
            Route::post('{id}', [AssistTerminalController::class, 'update']);
            Route::post('{id}/delete', [AssistTerminalController::class, 'delete']);
        });

        // teams
        Route::prefix('teams')->group(function () {
            Route::get('all', [UserTeamController::class, 'all']);
            Route::get('{slug}/isOwner', [UserTeamController::class, 'isOwner']);
            Route::get('{slug}/members', [UserTeamController::class, 'members']);
            Route::get('{slug}', [UserTeamController::class, 'slug']);
            Route::post('', [UserTeamController::class, 'create']);
            Route::post('{slug}/addMembers', [UserTeamController::class, 'addMembers']);
            Route::post('{slug}/delete', [UserTeamController::class, 'delete']);
            Route::post('members/{slug}/remove', [UserTeamController::class, 'removeMember']);
            Route::post('{slug}', [UserTeamController::class, 'update']);
        });

        // reports
        Route::get('reports/all', [ReportController::class, 'all']);

        // area
        Route::get('areas/all', [AreaController::class, 'all']);
        Route::post('areas', [AreaController::class, 'create']);
        Route::post('areas/{id}', [AreaController::class, 'update']);
        Route::post('areas/{id}/delete', [AreaController::class, 'delete']);

        // departments
        Route::get('departments/all', [DepartmentController::class, 'all']);
        Route::post('departments', [DepartmentController::class, 'create']);
        Route::post('departments/{id}', [DepartmentController::class, 'update']);
        Route::post('departments/{id}/delete', [DepartmentController::class, 'delete']);

        // jobs
        Route::get('jobs/all', [JobController::class, 'all']);
        Route::post('jobs', [JobController::class, 'create']);
        Route::post('jobs/{id}', [JobController::class, 'update']);
        Route::post('jobs/{id}/delete', [JobController::class, 'delete']);

        // roles
        Route::get('roles/all', [RoleController::class, 'all']);
        Route::post('roles', [RoleController::class, 'create']);
        Route::post('roles/{id}', [RoleController::class, 'update']);
        Route::post('roles/{id}/transfer', [RoleController::class, 'transfer']);
        Route::post('roles/{id}/delete', [RoleController::class, 'delete']);

        // roles
        Route::get('user-roles/all', [UserRoleController::class, 'all']);
        Route::post('user-roles', [UserRoleController::class, 'create']);
        Route::post('user-roles/{id}', [UserRoleController::class, 'update']);
        Route::post('user-roles/{id}/delete', [UserRoleController::class, 'delete']);

        // contract types
        Route::get('contract-types/all', [ContractTypeController::class, 'all']);
        Route::post('contract-types', [ContractTypeController::class, 'create']);
        Route::post('contract-types/{id}', [ContractTypeController::class, 'update']);
        Route::post('contract-types/{id}/delete', [ContractTypeController::class, 'delete']);

        // business units
        Route::get('businessUnits/all', [BusinessUnitController::class, 'all']);
        Route::post('businessUnits', [BusinessUnitController::class, 'create']);
        Route::post('businessUnits/{id}', [BusinessUnitController::class, 'update']);
        Route::post('businessUnits/{id}/delete', [BusinessUnitController::class, 'delete']);
    });
});
