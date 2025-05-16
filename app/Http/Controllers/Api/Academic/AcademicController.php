<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Pavilion;
use App\Models\Academic\Period;
use App\Models\Academic\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicController extends Controller
{
  public function index(Request $req)
  {
    // $businessUnitId = $req->get('businessUnitId');
    $periodId = $req->get('periodId');
    $programs = Program::get();
    $periods = Period::get();

    // ---- Schedules ----
    $querySchedules = DB::table('academic_programs as p')
      ->leftJoin('academic_sections as s', 's.programId', '=', 'p.id')
      ->leftJoin('academic_section_courses as sc', 'sc.sectionId', '=', 's.id')
      ->leftJoin('academic_section_course_schedules as scs', 'scs.sectionCourseId', '=', 'sc.id')
      ->select('p.id as programId', DB::raw('COUNT(scs.id) as total'))
      // ->where('p.businessUnitId', $businessUnitId)
      ->groupBy('p.id');
    if ($periodId) $querySchedules->where('s.periodId', $periodId);
    $schedules = $querySchedules->get();
    $schedulesGrouped = $schedules->reduce(function ($carry, $item) {
      $carry[$item->programId] = (int) $item->total;
      return $carry;
    }, []);

    // ---- Schedules ----
    $sectionsQuery = DB::table('academic_sections as s')
      ->join('academic_programs as pr', 'pr.id', '=', 's.programId')
      ->join('academic_periods as p', 'p.id', '=', 's.periodId')
      ->select('p.name as period', 's.programId', DB::raw('count(s.id) as total'))
      // ->when($businessUnitId, fn($q) => $q->where('pr.businessUnitId', $businessUnitId))
      ->groupBy('p.name', 's.programId')
      ->get();

    $sectionsGrouped = [];
    $programIds = $programs->pluck('id');
    foreach ($periods as $period) {
      $items = $sectionsQuery->where('period', $period->name);
      $sectionsGrouped[$period->name] = $programIds->mapWithKeys(
        fn($id) =>
        [$id => (int) ($items->firstWhere('programId', $id)->total ?? 0)]
      )->toArray();
    }

    // ---- Classrooms ----
    $types = [
      'Aula computo',
      'Aula teoria',
      'Aula virtual',
      'Lab. computo',
      'Lab. CIIE',
      'Taller enfermeria'
    ];

    $pavilions = Pavilion::get();
    $classroomsGroupedByType = array_fill_keys($types, 0);

    foreach ($pavilions->flatMap->classrooms as $classroom) {
      if (in_array($classroom->type, $types)) {
        $classroomsGroupedByType[$classroom->type]++;
      }
    }

    // ---- Plans of Study ----
    $plansQuery = DB::table('academic_plans')
      ->select('programId', DB::raw('count(id) as total'))
      ->whereIn('programId', $programs->pluck('id'))
      ->groupBy('programId')
      ->get();

    $plansGrouped = $programs->pluck('id')->mapWithKeys(
      fn($id) => [$id => (int) ($plansQuery->firstWhere('programId', $id)->total ?? 0)]
    )->toArray();

    return response()->json([
      'programs' => $programs->pluck('name', 'id'),
      'schedules' => [
        'data' => $schedulesGrouped,
        'total' => $schedules->sum('total'),
      ],
      'sections' => $sectionsGrouped,
      'classrooms' => $classroomsGroupedByType,
      'plans' => $plansGrouped
    ]);
  }
}
