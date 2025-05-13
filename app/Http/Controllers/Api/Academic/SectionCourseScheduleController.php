<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Jobs\ReportSendEmail;
use App\Models\Academic\Period;
use App\Models\Academic\Program;
use App\Models\Academic\SectionCourse;
use App\Models\Academic\SectionCourseSchedule;
use App\Models\Report;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                ['program' => $item->sectionCourse?->section?->program?->only(['id', 'name']) + [
                    'businessUnit' => $item->sectionCourse?->section?->program?->businessUnit?->only(['id', 'logoURL']),
                ]],
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

        // verify if section is available
        $section = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($item) {
            $query->where('sectionId', $item->sectionCourse->sectionId);
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
        $periodIds = $req->query('periodIds');
        $programIds = $req->query('programIds');

        $periodIds = $periodIds ? explode(',', $periodIds) : [];
        $programIds = $programIds ? explode(',', $programIds) : [];

        $match = SectionCourseSchedule::orderBy('created_at', 'desc');

        if ($periodIds) {
            $match->whereHas('sectionCourse.section', function ($query) use ($periodIds) {
                $query->whereIn('periodId', $periodIds);
            });
        }

        if ($programIds) {
            $match->whereHas('sectionCourse.section', function ($query) use ($programIds) {
                $query->whereIn('programId', $programIds);
            });
        }

        $schedulesRaw = $match->get();

        $allSchedules = collect();

        $dayNames = [
            '1' => 'Lunes',
            '2' => 'Martes',
            '3' => 'Miércoles',
            '4' => 'Jueves',
            '5' => 'Viernes',
            '6' => 'Sábado',
            '7' => 'Domingo',
        ];

        foreach ($schedulesRaw as $schedule) {
            foreach ($schedule->daysOfWeek as $day) {
                $clone = clone $schedule;
                $dayNum = trim($day);
                $clone->daysOfWeek = "$dayNum. " . ($dayNames[$dayNum] ?? $dayNum);
                $allSchedules->push($clone);
            }
        }

        $spreadsheet = IOFactory::load(public_path('templates/section_schedules.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $r = 2;

        $allSchedules = $allSchedules->sort(function ($a, $b) {
            return [
                $a->sectionCourse?->section?->period?->id,
                $a->sectionCourse?->section?->program?->businessUnit?->id,
                $a->sectionCourse?->section?->program?->id,
                $a->sectionCourse?->section?->id,
                $a->sectionCourse?->teacher?->id
            ]
                <=>
                [
                    $b->sectionCourse?->section?->period?->id,
                    $b->sectionCourse?->section?->program?->businessUnit?->id,
                    $b->sectionCourse?->section?->program?->id,
                    $b->sectionCourse?->section?->id,
                    $b->sectionCourse?->teacher?->id
                ];
        })->values();

        foreach ($allSchedules as $schedule) {

            $teacherNames = $schedule->sectionCourse?->teacher
                ? strtoupper($schedule->sectionCourse?->teacher?->lastNames) . ', ' . strtoupper($schedule->sectionCourse?->teacher?->firstNames)
                : '';
            $teacherDocumentId = $schedule->sectionCourse?->teacher
                ? $schedule->sectionCourse?->teacher?->documentId
                : '';

            $teacherEmail = $schedule->sectionCourse?->teacher
                ? $schedule->sectionCourse?->teacher?->email
                : '';

            $worksheet->setCellValue('A' . $r, $schedule->sectionCourse?->section?->period?->name);
            $worksheet->setCellValue('B' . $r, $schedule->startDate?->format('d/m/Y'));
            $worksheet->getStyle('B' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('C' . $r, $schedule->endDate?->format('d/m/Y'));
            $worksheet->getStyle('C' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('D' . $r, $schedule->sectionCourse?->section?->program?->businessUnit?->acronym);
            $worksheet->setCellValue('E' . $r, $schedule->sectionCourse?->section?->program?->name);
            $worksheet->setCellValue('F' . $r, $schedule->sectionCourse?->section?->cycle?->code);
            $worksheet->setCellValue('G' . $r, $schedule->sectionCourse?->section?->code);
            $worksheet->setCellValue('H' . $r, $schedule->sectionCourse?->planCourse?->name);
            $worksheet->setCellValue('I' . $r, $schedule->sectionCourse?->planCourse?->course?->code);
            $worksheet->setCellValue('J' . $r, $schedule->daysOfWeek);
            $worksheet->setCellValue('K' . $r, $schedule->startTime->format('H:i'));
            $worksheet->getStyle('K' . $r)->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue('L' . $r, $schedule->endTime->format('H:i'));
            $worksheet->getStyle('L' . $r)->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue('M' . $r, $schedule->classroom?->code);
            $worksheet->setCellValue('N' . $r, $schedule->classroom?->type);
            $worksheet->setCellValue('O' . $r, $teacherNames);
            $worksheet->setCellValue('P' . $r, $teacherDocumentId);
            $worksheet->setCellValue('Q' . $r, $teacherEmail);

            $r++;
        }

        Storage::makeDirectory('reports');

        $fileId = now()->timestamp;
        $filePath = 'reports/' . $fileId . '.xlsx';

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(storage_path('app/' . $filePath));

        $displayNameFile = 'Horarios ';

        if ($periodIds) {
            $periods = Period::whereIn('id', $periodIds)->get();
            $periodNames = $periods->pluck('name')->implode(', ');
            $displayNameFile .= '(periodos: ' . $periodNames . ', ';
        }

        if ($programIds) {
            $programs = Program::whereIn('id', $programIds)->get();
            $programAcronyms = $programs->pluck('acronym')->implode(', ');
            $displayNameFile .= 'programas: ' . $programAcronyms . ')';
        }

        $report = Report::create([
            'fileId' => $fileId,
            'title' => '' . $displayNameFile . '',
            'ext' => 'xlsx',
            'creatorId' => Auth::id(),
            'module' => 'academic',
        ]);

        $downloadLink = config('app.download_url') . '/reports/' . $report->id;

        ReportSendEmail::dispatch($report->title, 'académico', 'los horarios', $downloadLink, Auth::id());

        return response()->json($downloadLink);
    }
}
