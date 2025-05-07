<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Jobs\SectionSchedules;
use App\Models\Academic\SectionCourse;
use App\Models\Academic\SectionCourseSchedule;
use App\Models\UserSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionCourseScheduleController extends Controller
{
    public function index(Request $req)
    {
        $match = SectionCourseSchedule::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $classroomId = $req->query('classroomId');
        $sectionCourseId = $req->query('sectionCourseId');
        $sectionId = $req->query('sectionId');
        $teacherId = $req->query('teacherId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) {
            // $match->whereHas('sectionCourse', function ($query) use ($q) {
            //     $query->whereHas('section', function ($query) use ($q) {
            //         $query->where('code', 'like', "%$q%");
            //     })->orWhereHas('planCourse', function ($query) use ($q) {
            //         $query->whereHas('course', function ($query) use ($q) {
            //             $query->where('code', 'like', "%$q%")
            //                 ->orWhere('name', 'like', "%$q%");
            //         });
            //     });
            // });
        }

        if ($classroomId) $match->where('classroomId', $classroomId);
        if ($sectionCourseId) $match->where('sectionCourseId', $sectionCourseId);
        if ($teacherId) $match->whereHas('sectionCourse', function ($query) use ($teacherId) {
            $query->where('teacherId', $teacherId);
        });
        if ($sectionId) $match->whereHas('sectionCourse', function ($query) use ($sectionId) {
            $query->where('sectionId', $sectionId);
        });

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return array_merge(
                $item->only(['id', 'startTime', 'endTime', 'startDate', 'daysOfWeek', 'endDate']),
                ['program' => $item->sectionCourse?->section?->program?->only(['id', 'name'])],
                ['sectionCourse' => [
                    'teacher' => $item->sectionCourse->teacher ? $item->sectionCourse->teacher->only(['firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null,
                    'section' => $item->sectionCourse->section ? $item->sectionCourse->section->only(['id', 'code']) : null,
                    'planCourse' => $item->sectionCourse->planCourse ? $item->sectionCourse->planCourse->only(['name']) + [
                        'course' => $item->sectionCourse->planCourse->course ? $item->sectionCourse->planCourse->course->only(['code']) : null,
                    ] : null,
                ]],
                ['dates' => $item->dates],
                ['classroom' => $item->classroom ? $item->classroom->only(['id', 'code']) +
                    ['pavilion' => $item->classroom->pavilion ? $item->classroom->pavilion->only(['id', 'name']) : null]
                    : null],
            );
        });

        return response()->json(
            $paginate ? [
                ...$data->toArray(),
                'data' => $graphed,
            ] : $graphed
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'sectionCourseId' => 'required|string',
            'classroomId' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'daysOfWeek' => 'required|array',
        ]);

        $sectionCourse = SectionCourse::find($req->sectionCourseId);
        if (!$sectionCourse) return response()->json('not_found', 404);

        $startTime = date('H:i:s', strtotime($req->startTime));
        $endTime = date('H:i:s', strtotime($req->endTime));
        $startDate = date('Y-m-d', strtotime($req->startDate));
        $endDate = date('Y-m-d', strtotime($req->endDate));

        $daysConditions = implode(' OR ', array_map(fn($day) => "JSON_SEARCH(daysOfWeek, 'one', '$day') IS NOT NULL", $req->daysOfWeek));
        $daysConditions2 = implode(' OR ', array_map(fn($day) => "JSON_SEARCH(days, 'one', '$day') IS NOT NULL", $req->daysOfWeek));

        // verify if the teacher in the schedules exists schedules unavailable
        $teacher = UserSchedule::where('userId', $sectionCourse->teacherId)
            ->where('type', 'unavailable')
            ->whereRaw("($daysConditions2)")
            ->whereTime('from', '<', $endTime)
            ->whereTime('to', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verify if the classroom is available
        $classroom = SectionCourseSchedule::where('classroomId', $req->classroomId)
            ->whereRaw("($daysConditions)")
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verify if the teacher is available
        $teacherSection = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($sectionCourse) {
            $query->where('teacherId', $sectionCourse->teacherId);
        })->whereRaw("($daysConditions)")
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verify if section is available
        $section = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($sectionCourse) {
            $query->where('sectionId', $sectionCourse->sectionId);
        })->whereRaw("($daysConditions)")
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        if ($teacher) {
            return response()->json('El docente no está disponible en ese horario, por favor seleccione otro horario o cambie el docente del curso.', 409);
        }

        if ($classroom) {
            return response()->json('El aula ya está ocupada en ese horario, por favor seleccione otro horario o aula.', 409);
        }

        if ($teacherSection) {
            return response()->json('El docente ya está ocupado en ese horario, por favor seleccione otro horario o docente.', 409);
        }

        if ($section) {
            return response()->json('Hay un cruze de horarios con otros horarios de la sección, por favor seleccione otro horario.', 409);
        }

        $data = SectionCourseSchedule::create([
            'sectionCourseId' => $req->sectionCourseId,
            'classroomId' => $req->classroomId,
            'startDate' => $req->startDate,
            'endDate' => $req->endDate,
            'startTime' => $req->startTime,
            'endTime' => $req->endTime,
            'daysOfWeek' => $req->daysOfWeek,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'sectionCourseId' => 'required|string',
            'classroomId' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'daysOfWeek' => 'required|array',
        ]);

        $item = SectionCourseSchedule::find($id);
        if (!$item) return response()->json('not_found', 404);

        $startTime = date('H:i:s', strtotime($req->startTime));
        $endTime = date('H:i:s', strtotime($req->endTime));
        $startDate = date('Y-m-d', strtotime($req->startDate));
        $endDate = date('Y-m-d', strtotime($req->endDate));

        $daysConditions = implode(' OR ', array_map(fn($day) => "JSON_SEARCH(daysOfWeek, 'one', '$day') IS NOT NULL", $req->daysOfWeek));
        $daysConditions2 = implode(' OR ', array_map(fn($day) => "JSON_SEARCH(days, 'one', '$day') IS NOT NULL", $req->daysOfWeek));

        // verify if the teacher in the schedules exists schedules unavailable
        $teacher = UserSchedule::where('userId', $item->sectionCourse->teacherId)
            ->where('type', 'unavailable')
            ->whereRaw("($daysConditions2)")
            ->whereTime('from', '<', $endTime)
            ->whereTime('to', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verify if the classroom is available
        $classroom = SectionCourseSchedule::where('classroomId', $req->classroomId)
            ->whereRaw("($daysConditions)")
            ->where('id', '!=', $id)
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verify if the teacher is available
        $teacherSection = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($item) {
            $query->where('teacherId', $item->sectionCourse->teacherId);
        })->whereRaw("($daysConditions)")
            ->where('id', '!=', $id)
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        // verifu if section is available
        $section = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($item) {
            $query->where('sectionId', $item->sectionCourse->id);
        })->whereRaw("($daysConditions)")
            ->where('id', '!=', $id)
            ->whereTime('startTime', '<', $endTime)
            ->whereTime('endTime', '>', $startTime)
            ->whereDate('startDate', '<=', $endDate)
            ->whereDate('endDate', '>=', $startDate)
            ->exists();

        if ($teacher) {
            return response()->json('El docente no está disponible en ese horario, por favor seleccione otro horario o cambie el docente del curso.', 409);
        }

        if ($classroom) {
            return response()->json('El aula ya está ocupada en ese horario, por favor seleccione otro horario o aula.', 409);
        }

        if ($teacherSection) {
            return response()->json('El docente ya está ocupado en ese horario, por favor seleccione otro horario o docente.', 409);
        }

        if ($section) {
            return response()->json('Hay un cruze de horarios con otros horarios de la sección, por favor seleccione otro horario.', 409);
        }

        $item->update([
            'sectionCourseId' => $req->sectionCourseId,
            'classroomId' => $req->classroomId,
            'startDate' => $req->startDate,
            'endDate' => $req->endDate,
            'startTime' => $req->startTime,
            'endTime' => $req->endTime,
            'daysOfWeek' => $req->daysOfWeek,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = SectionCourseSchedule::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = SectionCourseSchedule::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            array_merge(
                $data->only(['id', 'startTime', 'endTime', 'startDate', 'endDate', 'daysOfWeek', 'created_at']),
                ['sectionCourse' => $data->sectionCourse ? $data->sectionCourse->only(['id']) + [
                    'section' => $data->sectionCourse->section ? $data->sectionCourse->section->only(['id', 'code', 'details']) : null,
                    'planCourse' => $data->sectionCourse->planCourse ? $data->sectionCourse->planCourse->only(['id', 'name', 'credits']) + [
                        'course' => $data->sectionCourse->planCourse->course ? $data->sectionCourse->planCourse->course->only(['id', 'code', 'name']) : null,
                    ] : null,
                    'teacher' => $data->sectionCourse->teacher ? $data->sectionCourse->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null,
                ] : null],
                ['classroom' => $data->classroom ? $data->classroom->only(['id', 'code', 'name']) : null],
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null],
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
            )
        );
    }

    public function report(Request $req)
    {
        $periodId = $req->query('periodId');
        $programId = $req->query('programId');
        $periodIds = $req->query('periodIds');
        $programIds = $req->query('programIds');

        $periodIds = $periodIds ? explode(',', $periodIds) : [];
        $programIds = $programIds ? explode(',', $programIds) : [];

        SectionSchedules::dispatch($programId,  $periodId, $periodIds, $programIds, Auth::id());

        return response()->json([
            'message' => 'El reporte se está generando, por favor revise su correo electrónico.',
        ]);
    }
}
