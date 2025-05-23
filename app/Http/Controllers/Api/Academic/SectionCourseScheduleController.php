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
        $classroomId = $req->query('classroomId');
        $sectionCourseId = $req->query('sectionCourseId');
        $sectionId = $req->query('sectionId');
        $teacherId = $req->query('teacherId');
        $paginate = $req->query('paginate') === 'true';

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
        $periodIds = $req->query('periodIds') ? explode(',', $req->query('periodIds')) : [];
        $programIds = $req->query('programIds') ? explode(',', $req->query('programIds')) : [];
        $programId = $req->query('programId');
        $periodId = $req->query('periodId');
        $q = $req->query('q');
        $query = SectionCourse::orderBy('created_at', 'desc');
        $query->where(function ($q) {
            $q->whereHas('planCourse', function ($subQuery) {
                $subQuery->where('status', true);
            });
        });

        foreach (
            [
                ['periodId', $periodIds],
                ['programId', $programIds]
            ] as [$key, $ids]
        ) {
            if ($ids) {
                $query->whereHas('section', fn($q) => $q->whereIn($key, $ids));
            }
        }

        foreach (
            [
                ['programId', $programId],
                ['periodId', $periodId]
            ] as [$key, $id]
        ) {
            if ($id) {
                $query->whereHas('section', fn($q) => $q->where($key, $id));
            }
        }

        if ($q) {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->whereHas('section', fn($q) => $q->where('code', 'like', "%$q%"))
                    ->orWhereHas(
                        'planCourse',
                        fn($q) =>
                        $q->whereHas(
                            'course',
                            fn($q) =>
                            $q->where('code', 'like', "%$q%")->orWhere('name', 'like', "%$q%")
                        )
                    )->orWhereHas(
                        'teacher',
                        fn($q) =>
                        $q->where('username', 'like', "%$q%")
                            ->orWhere('firstNames', 'like', "%$q%")
                            ->orWhere('documentId', 'like', "%$q%")
                            ->orWhere('lastNames', 'like', "%$q%")
                            ->orWhere('displayName', 'like', "%$q%")
                    );
            });
        }

        $schedulesRaw = $query->get()->flatMap(function ($course) {
            if ($course->schedules->isEmpty()) {
                return [[
                    'period' => $course->section?->period?->name,
                    'startDate' => $course->section?->period?->startDate,
                    'endDate' => $course->section?->period?->endDate,
                    'businessUnit' => $course->section?->program?->businessUnit?->acronym,
                    'program' => $course->section?->program?->name,
                    'cycle' => $course->section?->cycle?->code,
                    'section' => $course->section?->code,
                    'course' => $course->planCourse?->name,
                    'courseCode' => $course->planCourse?->course?->code,
                    'daysOfWeek' => [],
                    'startTime' => null,
                    'endTime' => null,
                    'classroom' => null,
                    'classroomType' => null,
                    'teacher' => $course->teacher,
                ]];
            }

            return $course->schedules->map(fn($s) => [
                'period' => $course->section?->period?->name,
                'startDate' => $course->section?->period?->startDate,
                'endDate' => $course->section?->period?->endDate,
                'businessUnit' => $course->section?->program?->businessUnit?->acronym,
                'program' => $course->section?->program?->name,
                'cycle' => $course->section?->cycle?->code,
                'section' => $course->section?->code,
                'course' => $course->planCourse?->name,
                'courseCode' => $course->planCourse?->course?->code,
                'daysOfWeek' => $s->daysOfWeek,
                'startTime' => $s->startTime,
                'endTime' => $s->endTime,
                'classroom' => $s->classroom?->code,
                'classroomType' => $s->classroom?->type,
                'teacher' => $course->teacher,
            ]);
        });

        $dayNames = ['1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado', '7' => 'Domingo'];
        $items = collect();

        foreach ($schedulesRaw as $schedule) {
            if (empty($schedule['daysOfWeek'])) {
                $schedule['daysOfWeek'] = '';
                $items->push($schedule);
            } else {
                foreach ($schedule['daysOfWeek'] as $day) {
                    $clone = $schedule;
                    $dayNum = trim($day);
                    $clone['daysOfWeek'] = "$dayNum. " . ($dayNames[$dayNum] ?? $dayNum);
                    $items->push($clone);
                }
            }
        }

        $spreadsheet = IOFactory::load(public_path('templates/section_schedules.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();
        $r = 2;

        $allItems = $items->sort(fn($a, $b) => [
            $a['period'],
            $a['businessUnit'],
            $a['program'],
            $a['section']
        ] <=> [
            $b['period'],
            $b['businessUnit'],
            $b['program'],
            $b['section']
        ])->values()->sortByDesc(fn($i) => !is_null($i['startTime']))->values();

        foreach ($allItems as $item) {
            $teacher = $item['teacher'];
            $worksheet->setCellValue("A$r", $item['period']);
            $worksheet->setCellValue("B$r", $item['startDate']?->format('d/m/Y'));
            $worksheet->getStyle("B$r")->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue("C$r", $item['endDate']?->format('d/m/Y'));
            $worksheet->getStyle("C$r")->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue("D$r", $item['businessUnit']);
            $worksheet->setCellValue("E$r", $item['program']);
            $worksheet->setCellValue("F$r", $item['cycle']);
            $worksheet->setCellValue("G$r", $item['section']);
            $worksheet->setCellValue("H$r", $item['course']);
            $worksheet->setCellValue("I$r", $item['courseCode']);
            $worksheet->setCellValue("J$r", $item['daysOfWeek']);
            $worksheet->setCellValue("K$r", $item['startTime']?->format('H:i'));
            $worksheet->getStyle("K$r")->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue("L$r", $item['endTime']?->format('H:i'));
            $worksheet->getStyle("L$r")->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue("M$r", $item['classroom']);
            $worksheet->setCellValue("N$r", $item['classroomType']);
            $worksheet->setCellValue("O$r", $teacher ? strtoupper($teacher->fullNames()) : '');
            $worksheet->setCellValue("P$r", $teacher?->documentId);
            $worksheet->setCellValue("Q$r", $teacher?->email);
            $r++;
        }

        Storage::makeDirectory('reports');
        $fileId = now()->timestamp;
        $filePath = "reports/$fileId.xlsx";

        IOFactory::createWriter($spreadsheet, 'Xlsx')->save(storage_path("app/$filePath"));

        $displayNameFile = 'Horarios ';
        if ($periodIds) {
            $displayNameFile .= '(periodos: ' . Period::whereIn('id', $periodIds)->pluck('name')->implode(', ') . ', ';
        }
        if ($programIds) {
            $displayNameFile .= 'programas: ' . Program::whereIn('id', $programIds)->pluck('acronym')->implode(', ') . ')';
        }
        if ($programId && $periodId) {
            $displayNameFile .= '(programa: ' . Program::find($programId)?->acronym . ', periodo: ' . Period::find($periodId)?->name . ')';
        }

        $report = Report::create([
            'fileId' => $fileId,
            'title' => $displayNameFile,
            'ext' => 'xlsx',
            'creatorId' => Auth::id(),
            'module' => 'academic',
        ]);

        $downloadLink = config('app.download_url') . '/reports/' . $report->id;
        ReportSendEmail::dispatch($report->title, 'académico', 'los horarios', $downloadLink, Auth::id());

        return response()->json($downloadLink);
    }
}
