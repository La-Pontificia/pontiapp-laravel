<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classroom;
use App\Models\Academic\SectionCourse;
use App\Models\Academic\SectionCourseSchedule;
use App\Models\User;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ScheduleController extends Controller
{
    public function verifyImportFile(Request $req)
    {
        $file = $req->file('file');

        if (!$file) {
            return response()->json('No file uploaded', 400);
        }

        $validTypes = ['xlsx', 'xls'];
        if (!in_array($file->getClientOriginalExtension(), $validTypes)) {
            return response()->json('Invalid file type', 400);
        }

        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $headers = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn() . '1')[0];

        // Validate headers
        $expectedHeaders = ['Prog. Academico', 'Programa de estudios', 'Plan', 'Curso', 'Grupo', 'Docente', 'Dia', 'Aula', 'Tipo', 'Hora Inicio', 'Hora Fin', 'Fecha Inicio', 'Fecha Fin'];
        if ($headers !== $expectedHeaders) {
            return response()->json('Los encabezados del archivo no son válidos, por favor asegurese de utilizar la plantilla correcta.', 422);
        }

        // extract data 
        $rows = $sheet->toArray(null, true, true, true);
        $json = [];

        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i];

            if (!isset($row['G'], $row['I'], $row['J'])) {
                continue;
            }

            $sectionCourse = SectionCourse::whereHas('section', function ($query) use ($row) {
                $query->where('code', $row['E']);
            })
                ->whereHas('planCourse', function ($query) use ($row) {
                    $query->whereHas('course', function ($query) use ($row) {
                        $query->where('code', $row['D']);
                    });
                })
                ->first();

            $classRoom = Classroom::where('pontisisCode', $row['H'])->first();
            $teacher = User::where('documentId', $row['F'])->first();

            if (!$sectionCourse) {
                return response()->json('Las seccion ' . $row['E'] . ' no existe en el sistema.', 404);
            }

            if (!$classRoom) {
                return response()->json('El aula ' . $row['H'] . ' no existe en el sistema.', 404);
            }

            $day = (int) explode('.', $row['G'])[0];

            $json[] = [
                'teacherId' => $teacher ? $teacher->id : null,
                'sectionCourseId' => $sectionCourse->id,
                'classroomId' => $classRoom->id,
                'startDate' => \Carbon\Carbon::createFromFormat('d/m/Y', $row['L'])->format('Y-m-d'),
                'endDate' => \Carbon\Carbon::createFromFormat('d/m/Y', $row['M'])->format('Y-m-d'),

                'startTime' => date('H:i:s', strtotime($row['J'])) ?? null,
                'endTime' => date('H:i:s', strtotime($row['K'])) ?? null,
                'daysOfWeek' => [$day]
            ];
        }

        return response()->json($json, 200);
    }

    public function import(Request $req)
    {
        $req->validate([
            'data' => 'required|array',
        ]);

        $data = $req->input('data');
        if (empty($data)) {
            return response()->json('No data provided for import', 400);
        }

        $withoutConflicts = [];

        foreach ($data as $item) {
            $startDate = $item['startDate'];
            $endDate = $item['endDate'];
            $startTime = $item['startTime'];
            $endTime = $item['endTime'];
            $days = $item['daysOfWeek'];

            $sectionCourse = SectionCourse::find($item['sectionCourseId']);

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

                'classroom_busy' => SectionCourseSchedule::where('classroomId', $item['classroomId'])
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
                                'classroom' => $conflictItem->classroom->code,
                                'classroomCode' => $conflictItem->classroom->pontisisCode,
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

            $withoutConflicts[] = [
                'sectionCourseId' => $item['sectionCourseId'],
                'classroomId' => $item['classroomId'],
                'startDate' => $item['startDate'],
                'endDate' => $item['endDate'],
                'startTime' => $startTime,
                'endTime' => $endTime,
                'daysOfWeek' => $item['daysOfWeek'],
                'creatorId' => Auth::id(),
            ];
        }

        // create many schedules
        SectionCourseSchedule::insert($withoutConflicts);

        return response()->json($withoutConflicts, 200);
    }
}
