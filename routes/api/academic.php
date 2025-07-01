<?php

use App\Http\Controllers\Api\Academic\AcademicController;
use App\Http\Controllers\Api\Academic\AreaController;
use App\Http\Controllers\Api\Academic\ClassroomController;
use App\Http\Controllers\Api\Academic\ClassTypeController;
use App\Http\Controllers\Api\Academic\CourseController;
use App\Http\Controllers\Api\Academic\CycleController;
use App\Http\Controllers\Api\Academic\PavilionController;
use App\Http\Controllers\Api\Academic\PeriodController;
use App\Http\Controllers\Api\Academic\PlanController;
use App\Http\Controllers\Api\Academic\PlanCourseController;
use App\Http\Controllers\Api\Academic\ProgramController;
use App\Http\Controllers\Api\Academic\ScheduleController;
use App\Http\Controllers\Api\Academic\SectionController;
use App\Http\Controllers\Api\Academic\SectionCourseController;
use App\Http\Controllers\Api\Academic\SectionCourseScheduleController;
use App\Http\Controllers\Api\Academic\TeacherController;
use App\Http\Controllers\Api\Academic\TeacherTrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function () {
    Route::prefix('academic')->group(function () {
        Route::get('stadistics', [AcademicController::class, 'index']);
        Route::prefix('teachers')->group(function () {
            Route::get('', [TeacherController::class, 'index']);
            Route::post('schedules/{id}', [TeacherController::class, 'updateSchedule']);
            Route::post('schedules/{id}/delete', [TeacherController::class, 'deleteSchedule']);
            Route::post('schedules', [TeacherController::class, 'storeSchedule']);
            Route::get('{id}/schedules', [TeacherController::class, 'schedules']);
        });
        Route::prefix('tt')->group(function () {
            Route::get('', [TeacherTrackingController::class, 'index']);
            Route::post('store', [TeacherTrackingController::class, 'store']);
            Route::post('report', [TeacherTrackingController::class, 'report']);
            Route::post('{slug}', [TeacherTrackingController::class, 'update']);
            Route::post('{slug}/delete', [TeacherTrackingController::class, 'delete']);
            Route::get('{slug}', [TeacherTrackingController::class, 'one']);
        });
        Route::prefix('programs')->group(function () {
            Route::get('', [ProgramController::class, 'index']);
            Route::get('{slug}', [ProgramController::class, 'one']);
            Route::post('', [ProgramController::class, 'store']);
            Route::post('{slug}', [ProgramController::class, 'update']);
            Route::post('{slug}/delete', [ProgramController::class, 'delete']);
        });

        Route::prefix('courses')->group(function () {
            Route::get('', [CourseController::class, 'index']);
            Route::get('{slug}', [CourseController::class, 'one']);
            Route::post('', [CourseController::class, 'store']);
            Route::post('{slug}', [CourseController::class, 'update']);
            Route::post('{slug}/delete', [CourseController::class, 'delete']);
        });

        Route::prefix('plans')->group(function () {
            Route::prefix('courses')->group(function () {
                Route::get('', [PlanCourseController::class, 'index']);
                Route::post('', [PlanCourseController::class, 'store']);
                Route::get('{slug}', [PlanCourseController::class, 'one']);
                Route::post('{slug}', [PlanCourseController::class, 'update']);
                Route::post('{slug}/delete', [PlanCourseController::class, 'delete']);
                Route::post('{slug}/status', [PlanCourseController::class, 'status']);
            });

            Route::get('', [PlanController::class, 'index']);
            Route::post('', [PlanController::class, 'store']);
            Route::get('{slug}', [PlanController::class, 'one']);
            Route::post('{slug}', [PlanController::class, 'update']);
            Route::post('{slug}/delete', [PlanController::class, 'delete']);
        });
        Route::prefix('periods')->group(function () {
            Route::get('', [PeriodController::class, 'index']);
            Route::get('{slug}', [PeriodController::class, 'one']);
            Route::post('', [PeriodController::class, 'store']);
            Route::post('{slug}', [PeriodController::class, 'update']);
            Route::post('{slug}/delete', [PeriodController::class, 'delete']);
        });
        Route::prefix('pavilions')->group(function () {
            Route::get('', [PavilionController::class, 'index']);
            Route::get('{slug}', [PavilionController::class, 'one']);
            Route::post('', [PavilionController::class, 'store']);
            Route::post('{slug}', [PavilionController::class, 'update']);
            Route::post('{slug}/delete', [PavilionController::class, 'delete']);
        });
        Route::prefix('classrooms')->group(function () {
            Route::prefix('types')->group(function () {
                Route::get('', [ClassTypeController::class, 'index']);
                Route::get('{slug}', [ClassTypeController::class, 'one']);
                Route::post('', [ClassTypeController::class, 'store']);
                Route::post('{slug}', [ClassTypeController::class, 'update']);
                Route::post('{slug}/delete', [ClassTypeController::class, 'delete']);
            });
            Route::get('', [ClassroomController::class, 'index']);
            Route::get('{slug}', [ClassroomController::class, 'one']);
            Route::post('', [ClassroomController::class, 'store']);
            Route::post('{slug}', [ClassroomController::class, 'update']);
            Route::post('{slug}/delete', [ClassroomController::class, 'delete']);
        });
        Route::prefix('sections')->group(function () {
            Route::prefix('courses')->group(function () {
                Route::prefix('schedules')->group(function () {
                    Route::get('', [SectionCourseScheduleController::class, 'index']);
                    Route::get('{slug}', [SectionCourseScheduleController::class, 'one']);
                    Route::post('', [SectionCourseScheduleController::class, 'store']);
                    Route::post('report', [SectionCourseScheduleController::class, 'report']);
                    Route::post('report-pontisis', [SectionCourseScheduleController::class, 'reportPontisis']);
                    Route::post('report-pontisis-teachers', [SectionCourseScheduleController::class, 'reportPontisisTeachers']);
                    Route::post('{slug}', [SectionCourseScheduleController::class, 'update']);
                    Route::post('{slug}/delete', [SectionCourseScheduleController::class, 'delete']);
                });
                Route::get('', [SectionCourseController::class, 'index']);
                Route::get('calendar/{id}', [SectionCourseController::class, 'schedules']);
                Route::get('{slug}', [SectionCourseController::class, 'one']);
                Route::post('', [SectionCourseController::class, 'store']);
                Route::post('{slug}', [SectionCourseController::class, 'update']);
                Route::post('{slug}/delete', [SectionCourseController::class, 'delete']);
            });
            Route::get('', [SectionController::class, 'index']);
            Route::get('{slug}', [SectionController::class, 'one']);
            Route::post('', [SectionController::class, 'store']);
            Route::post('{slug}', [SectionController::class, 'update']);
            Route::post('{slug}/delete', [SectionController::class, 'delete']);
        });

        Route::prefix('cycles')->group(function () {
            Route::get('', [CycleController::class, 'index']);
            Route::post('', [CycleController::class, 'store']);
            Route::post('{slug}', [CycleController::class, 'update']);
            Route::post('{slug}/delete', [CycleController::class, 'delete']);
        });

        Route::prefix('areas')->group(function () {
            Route::get('', [AreaController::class, 'index']);
            Route::get('{slug}', [AreaController::class, 'one']);
            Route::post('', [AreaController::class, 'store']);
            Route::post('{slug}', [AreaController::class, 'update']);
            Route::post('{slug}/delete', [AreaController::class, 'delete']);
        });
    });
});
