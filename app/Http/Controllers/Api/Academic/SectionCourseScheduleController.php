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
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
        $validated = $req->validate([
            'sectionCourseId' => 'required|string',
            'classroomId' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'daysOfWeek' => 'required|array',
        ]);

        $sectionCourse = SectionCourse::find($validated['sectionCourseId']);
        if (!$sectionCourse) return response()->json('not_found', 404);

        $startTime = date('H:i:s', strtotime($validated['startTime']));
        $endTime = date('H:i:s', strtotime($validated['endTime']));
        $startDate = date('Y-m-d', strtotime($validated['startDate']));
        $endDate = date('Y-m-d', strtotime($validated['endDate']));
        $days = $validated['daysOfWeek'];

        $buildSearch = fn($column) => implode(' OR ', array_map(fn($day) => "JSON_SEARCH($column, 'one', '$day') IS NOT NULL", $days));

        $conflicts = [
            'teacher_unavailable' => UserSchedule::where('userId', $sectionCourse->teacherId)
                ->where('type', 'unavailable')
                ->whereRaw('(' . $buildSearch('days') . ')')
                ->whereTime('from', '<', $endTime)
                ->whereTime('to', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->first(),

            'classroom_busy' => SectionCourseSchedule::where('classroomId', $validated['classroomId'])
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->first(),

            'teacher_busy' => SectionCourseSchedule::whereHas('sectionCourse', function ($q) use ($sectionCourse) {
                $q->where('teacherId', $sectionCourse->teacherId);
            })
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->first(),

            'section_busy' => SectionCourseSchedule::whereHas('sectionCourse', function ($q) use ($sectionCourse) {
                $q->where('sectionId', $sectionCourse->sectionId);
            })
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->first(),
        ];

        $messages = [
            'teacher_unavailable' => 'El docente no está disponible en ese horario.',
            'classroom_busy' => 'El aula ya está ocupada en ese horario.',
            'teacher_busy' => 'El docente ya está ocupado en ese horario.',
            'section_busy' => '🙅 Hay cruces de horario en la sección, por favor selecciona otro rango de horario.'
        ];

        foreach ($conflicts as $type => $conflictItem) {
            if ($conflictItem) {
                switch ($type) {
                    case 'teacher_unavailable':
                        $item = [
                            'name' => $conflictItem->user->fullNames() . ' (No disponible)',
                            'startDate' => $conflictItem->startDate,
                            'endDate' => $conflictItem->endDate,
                            'startTime' => $conflictItem->from,
                            'dates' => $conflictItem->dates,
                            'endTime' => $conflictItem->to,
                            'daysOfWeek' => $conflictItem->days,
                        ];
                        break;
                    default:
                        $item = [
                            'name' => $conflictItem->sectionCourse->planCourse->course->name,
                            'startDate' => $conflictItem->startDate,
                            'endDate' => $conflictItem->endDate,
                            'startTime' => $conflictItem->startTime,
                            'endTime' => $conflictItem->endTime,
                            'dates' => $conflictItem->dates,
                            'daysOfWeek' => $conflictItem->daysOfWeek,
                        ];
                        break;
                }

                return response()->json([
                    'message' => $messages[$type],
                    'item' => $item,
                ], 409);
            }
        }

        $data = SectionCourseSchedule::create([
            'sectionCourseId' => $validated['sectionCourseId'],
            'classroomId' => $validated['classroomId'],
            'startDate' => $validated['startDate'],
            'endDate' => $validated['endDate'],
            'startTime' => $validated['startTime'],
            'endTime' => $validated['endTime'],
            'daysOfWeek' => $validated['daysOfWeek'],
            'creatorId' => Auth::id(),
        ]);

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'classroomId' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'daysOfWeek' => 'required|array',
        ]);

        $item = SectionCourseSchedule::find($id);
        if (!$item) return response()->json('not_found', 404);

        $validated = $req->validate([
            'sectionCourseId' => 'required|string',
            'classroomId' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'daysOfWeek' => 'required|array',
        ]);

        $sectionCourse = SectionCourse::find($validated['sectionCourseId']);
        if (!$sectionCourse) return response()->json('not_found', 404);

        $startTime = date('H:i:s', strtotime($validated['startTime']));
        $endTime = date('H:i:s', strtotime($validated['endTime']));
        $startDate = date('Y-m-d', strtotime($validated['startDate']));
        $endDate = date('Y-m-d', strtotime($validated['endDate']));
        $days = $validated['daysOfWeek'];

        $buildSearch = fn($column) => implode(' OR ', array_map(fn($day) => "JSON_SEARCH($column, 'one', '$day') IS NOT NULL", $days));

        $conflicts = [
            'teacher_unavailable' => UserSchedule::where('userId', $sectionCourse->teacherId)
                ->where('type', 'unavailable')
                ->whereRaw('(' . $buildSearch('days') . ')')
                ->whereTime('from', '<', $endTime)
                ->whereTime('to', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->first(),

            'classroom_busy' => SectionCourseSchedule::where('classroomId', $validated['classroomId'])
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->where('id', '!=', $id) // Exclude the current schedule
                ->first(),

            'teacher_busy' => SectionCourseSchedule::whereHas('sectionCourse', function ($q) use ($sectionCourse) {
                $q->where('teacherId', $sectionCourse->teacherId);
            })
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->where('id', '!=', $id) // Exclude the current schedule
                ->first(),

            'section_busy' => SectionCourseSchedule::whereHas('sectionCourse', function ($q) use ($sectionCourse) {
                $q->where('sectionId', $sectionCourse->sectionId);
            })
                ->whereRaw('(' . $buildSearch('daysOfWeek') . ')')
                ->whereTime('startTime', '<', $endTime)
                ->whereTime('endTime', '>', $startTime)
                ->whereDate('startDate', '<=', $endDate)
                ->whereDate('endDate', '>=', $startDate)
                ->where('id', '!=', $id) // Exclude the current schedule
                ->first(),
        ];

        $messages = [
            'teacher_unavailable' => 'El docente no está disponible en ese horario.',
            'classroom_busy' => 'El aula ya está ocupada en ese horario.',
            'teacher_busy' => 'El docente ya está ocupado en ese horario.',
            'section_busy' => '🙅 Hay cruces de horario en la sección, por favor selecciona otro rango de horario.'
        ];

        foreach ($conflicts as $type => $conflictItem) {
            if ($conflictItem) {
                switch ($type) {
                    case 'teacher_unavailable':
                        $item = [
                            'name' => $conflictItem->user->fullNames() . ' (No disponible)',
                            'startDate' => $conflictItem->startDate,
                            'endDate' => $conflictItem->endDate,
                            'startTime' => $conflictItem->from,
                            'dates' => $conflictItem->dates,
                            'endTime' => $conflictItem->to,
                            'daysOfWeek' => $conflictItem->days,
                        ];
                        break;
                    default:
                        $item = [
                            'name' => $conflictItem->sectionCourse->planCourse->course->name,
                            'startDate' => $conflictItem->startDate,
                            'endDate' => $conflictItem->endDate,
                            'startTime' => $conflictItem->startTime,
                            'endTime' => $conflictItem->endTime,
                            'dates' => $conflictItem->dates,
                            'daysOfWeek' => $conflictItem->daysOfWeek,
                        ];
                        break;
                }

                return response()->json([
                    'message' => $messages[$type],
                    'item' => $item,
                ], 409);
            }
        }

        $item->update([
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
        $type = $req->query('type');
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
                    'programPontisisCode' => $course->section?->program?->pontisisCode,
                    'planPontisisCode' => $course->planCourse?->plan?->pontisisCode,
                    'cycle' => $course->section?->cycle?->code,
                    'section' => $course->section?->code,
                    'course' => $course->planCourse?->name,
                    'courseCode' => $course->planCourse?->course?->code,
                    'daysOfWeek' => [],
                    'startTime' => null,
                    'endTime' => null,
                    'classroom' => null,
                    'classroomType' => null,
                    'classroomPontisisCode' => null,
                    'classroomTypePontisisCode' => null,
                    'teacher' => $course->teacher,
                ]];
            }

            return $course->schedules->map(fn($s) => [
                'period' => $course->section?->period?->name,
                'startDate' => $course->section?->period?->startDate,
                'endDate' => $course->section?->period?->endDate,
                'businessUnit' => $course->section?->program?->businessUnit?->acronym,
                'program' => $course->section?->program?->name,
                'programPontisisCode' => $course->section?->program?->pontisisCode,
                'planPontisisCode' => $course->planCourse?->plan?->pontisisCode,
                'cycle' => $course->section?->cycle?->code,
                'section' => $course->section?->code,
                'course' => $course->planCourse?->name,
                'courseCode' => $course->planCourse?->course?->code,
                'daysOfWeek' => $s->daysOfWeek,
                'startTime' => $s->startTime,
                'endTime' => $s->endTime,
                'classroom' => $s->classroom?->code,
                'classroomType' => $s->classroom?->type,
                'classroomPontisisCode' => $s->classroom?->pontisisCode,
                'classroomTypePontisisCode' => $s->classroom?->type?->pontisisCode,
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
                    if ($type === 'pontisis') {
                        $clone['daysOfWeek'] = $dayNum;
                    } else {
                        $clone['daysOfWeek'] = "$dayNum. " . ($dayNames[$dayNum] ?? $dayNum);
                    }
                    $items->push($clone);
                }
            }
        }

        $template = $type === 'pontisis' ? 'templates/section_schedule_pontisis.xlsx' : 'templates/section_schedules.xlsx';
        $spreadsheet = IOFactory::load(public_path($template));
        $worksheet = $type === 'pontisis' ? $spreadsheet->getSheetByName('Data A Importar') : $spreadsheet->getActiveSheet();
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
            if ($type === 'pontisis') {
                $worksheet->setCellValue("A$r", 'G');
                $worksheet->setCellValue("B$r", $item['programPontisisCode']);
                $worksheet->setCellValue("C$r", $item['planPontisisCode']);
                $worksheet->setCellValue("D$r", $item['courseCode']);
                $worksheet->setCellValue("E$r", $item['section']);
                $worksheet->setCellValue("F$r", $teacher?->documentId);

                // daysOfWeek only first and only number
                $daysOfWeek = collect($item['daysOfWeek'])->map(fn($day) => trim(explode('.', $day)[0]))->implode(', ');
                $worksheet->setCellValue("G$r", $daysOfWeek);
                $worksheet->setCellValue("H$r", $item['classroomPontisisCode']);
                $worksheet->setCellValue("I$r", $item['classroomTypePontisisCode']);
                $worksheet->setCellValue("J$r",  $item['startTime']?->format('H:i'));
                $worksheet->getStyle("J$r")->getNumberFormat()->setFormatCode('HH:MM');
                $worksheet->setCellValue("K$r",  $item['endTime']?->format('H:i'));
                $worksheet->getStyle("K$r")->getNumberFormat()->setFormatCode('HH:MM');


                $worksheet->setCellValue("L$r", Date::PHPToExcel($item['startDate']));
                $worksheet->getStyle("L$r")->getNumberFormat()->setFormatCode('YYYY/MM/DD');
                $worksheet->setCellValue("M$r", Date::PHPToExcel($item['endDate']));
                $worksheet->getStyle("M$r")->getNumberFormat()->setFormatCode('YYYY/MM/DD');
            } else {
                $worksheet->setCellValue("A$r", $item['period']);
                $worksheet->setCellValue("B$r", Date::PHPToExcel($item['startDate']));
                $worksheet->getStyle("B$r")->getNumberFormat()->setFormatCode('YYYY/MM/DD');
                $worksheet->setCellValue("C$r", Date::PHPToExcel($item['endDate']));
                $worksheet->getStyle("C$r")->getNumberFormat()->setFormatCode('YYYY/MM/DD');
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
                $worksheet->setCellValue("N$r", $item['classroomType']->name ?? '');
                $worksheet->setCellValue("O$r", $teacher ? strtoupper($teacher->fullNames()) : '');
                $worksheet->setCellValue("P$r", $teacher?->documentId);
                $worksheet->setCellValue("Q$r", $teacher?->email);
            }
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

        if ($type === 'pontisis') {
            $displayNameFile .= ' - Pontisis';
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
