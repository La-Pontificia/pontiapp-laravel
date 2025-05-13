<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\SectionCourseSchedule;
use App\Models\User;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
  public function index(Request $req)
  {
    $teacherRoleId = '9e23d945-bac1-40f9-9917-6ce55a02de7c';

    $match = User::orderBy('created_at', 'asc');
    $q = $req->query('q');
    $paginate = $req->query('paginate') === 'true';

    $match->where(function ($query) use ($teacherRoleId) {
      $query->where('roleId', $teacherRoleId)
        ->orWhere('role2Id', $teacherRoleId);
    });


    if ($q) {
      $match->where(function ($subQuery) use ($q) {
        $subQuery->where('fullName', 'like', '%' . $q . '%')
          ->orWhere('documentId', 'like', '%' . $q . '%')
          ->orWhere('displayName', 'like', '%' . $q . '%')
          ->orWhere('email', 'like', '%' . $q . '%');
      });
    }

    $data = $paginate ? $match->paginate(25) : $match->get();

    $graphed = $data->map(function ($item) {
      $schedules = UserSchedule::where('userId', $item->id)->where('type', 'unavailable')->get();
      return array_merge(
        $item->only(['id', 'firstNames', 'username', 'lastNames', 'displayName', 'email', 'photoURL']),
        ['schedulesNotAvailable' => $schedules->map(function ($schedule) {
          return $schedule->only(['startDate', 'endDate', 'from', 'to']);
        })]
      );
    });

    return response()->json(
      $paginate ? [
        ...$data->toArray(),
        'data' => $graphed,
      ] : $graphed
    );
  }
  public function schedules(Request $req, $id)
  {
    $data1 = UserSchedule::where('userId', $id)->where('type', 'unavailable')->get();
    $data2 = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($id) {
      $query->where('teacherId', $id);
    })
      ->orderBy('created_at', 'asc')
      ->get();

    $unavailable = $data1->map(function ($schedule) {
      return array_merge(
        $schedule->only(['id', 'startDate', 'endDate', 'days', 'from', 'to']),
        ['dates' => $schedule->dates]
      );
    });

    $classSchedules = $data2->map(function ($item) {
      return array_merge(
        $item->only(['id', 'startTime', 'endTime', 'startDate', 'daysOfWeek', 'endDate', 'created_at']),
        ['program' => $item->sectionCourse?->section?->program?->only(['id', 'name']) + [
          'businessUnit' => $item->sectionCourse?->section?->program?->businessUnit?->only(['id', 'logoURL']),
        ]],
        ['sectionCourse' => $item->sectionCourse ? $item->sectionCourse->only(['id']) + [
          'planCourse' => $item->sectionCourse->planCourse ? $item->sectionCourse->planCourse->only(['id', 'name', 'credits']) + [
            'course' => $item->sectionCourse->planCourse->course ? $item->sectionCourse->planCourse->course->only(['id', 'code']) : null,
          ] : null,
        ] : null],
        ['dates' => $item->dates],
        ['classroom' => $item->classroom ? $item->classroom->only(['id', 'code', 'name']) +
          ['pavilion' => $item->classroom->pavilion ? $item->classroom->pavilion->only(['id', 'name']) : null]
          : null],
      );
    });

    return response()->json(
      [
        'unavailable' => $unavailable,
        'classSchedules' => $classSchedules,
      ]
    );
  }

  public function storeSchedule(Request $req)
  {
    $req->validate(rules: [
      'userId' => 'required|exists:users,id',
      'from' => 'required|date',
      'to' => 'required|date',
      'days' => 'required|array',
      'startDate' => 'required|date',
      'endDate' => 'required|date',
    ]);

    $teacher = User::findOrFail($req->userId);
    if (!$teacher) {
      return response()->json('not_found', 400);
    }

    $schedule = new UserSchedule();
    $schedule->userId = $req->userId;
    $schedule->from = $req->from;
    $schedule->to = $req->to;
    $schedule->type = 'unavailable';
    $schedule->days = $req->days;
    $schedule->startDate = $req->startDate;
    $schedule->endDate = $req->endDate;
    $schedule->creatorId = Auth::id();
    $schedule->save();
    return response()->json('Schedule created successfully');
  }

  public function updateSchedule(Request $req, $id)
  {

    $schedule = UserSchedule::findOrFail($id);

    $req->validate(rules: [
      'from' => 'required|date',
      'to' => 'required|date',
      'days' => 'required|array',
      'startDate' => 'required|date',
      'endDate' => 'required|date',
    ]);

    if (!$schedule) {
      return response()->json('not_found', 400);
    }

    $schedule->from = $req->from;
    $schedule->to = $req->to;
    $schedule->type = 'unavailable';
    $schedule->days = $req->days;
    $schedule->startDate = $req->startDate;
    $schedule->endDate = $req->endDate;
    $schedule->updaterId = Auth::id();
    $schedule->save();

    return response()->json('Schedule created successfully');
  }
  public function deleteSchedule($id)
  {
    $schedule = UserSchedule::findOrFail($id);
    if (! $schedule) {
      return response()->json('not_found', 400);
    }
    $schedule->delete();
    return response()->json('');
  }
}
