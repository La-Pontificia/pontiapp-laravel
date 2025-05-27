<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\SectionCourse;

use App\Models\Academic\SectionCourseSchedule;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionCourseController extends Controller
{
    public function index(Request $req)
    {
        $match = SectionCourse::orderBy('created_at', 'asc')
            ->whereHas('planCourse', function ($query) {
                $query->where('status', true);
            });

        $q = $req->query('q');
        $sectionId = $req->query('sectionId');
        $programId = $req->query('programId');
        $periodId = $req->query('periodId');
        $courseId = $req->query('courseId');
        $teacherId = $req->query('teacherId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) {
            $match->where(function ($subQuery) use ($q) {
                $subQuery->whereHas('section', function ($subQuery) use ($q) {
                    $subQuery->where('code', 'like', "%$q%");
                })->orWhereHas('planCourse', function ($subQuery) use ($q) {
                    $subQuery->whereHas('course', function ($subQuery) use ($q) {
                        $subQuery->where('code', 'like', "%$q%")
                            ->orWhere('name', 'like', "%$q%");
                    });
                })->orWhereHas('teacher', function ($subQuery) use ($q) {
                    $subQuery->where('username', 'like', "%$q%")
                        ->orWhere('firstNames', 'like', "%$q%")
                        ->orWhere('documentId', 'like', "%$q%")
                        ->orWhere('lastNames', 'like', "%$q%")
                        ->orWhere('displayName', 'like', "%$q%");
                });
            });
        }

        if ($sectionId) $match->where('sectionId', $sectionId);
        if ($periodId) $match->whereHas('section', function ($query) use ($periodId) {
            $query->where('periodId', $periodId);
        });
        if ($courseId) $match->where('courseId', $courseId);
        if ($teacherId) $match->where('teacherId', $teacherId);
        if ($programId) $match->whereHas('section', function ($query) use ($programId) {
            $query->where('programId', $programId);
        });

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return array_merge(
                $item->only(['id', 'created_at']),
                ['section' => $item->section ? $item->section->only(['id', 'code', 'details']) : null],
                ['planCourse' => $item->planCourse ? $item->planCourse->only(['id', 'name', 'credits']) + [
                    'course' => $item->planCourse->course ? $item->planCourse->course->only(['id', 'code', 'name']) : null,
                    'plan' => $item->planCourse->plan ? $item->planCourse->plan->only(['id', 'name']) : null,
                ] : null],
                ['schedulesCount' => $item->schedules ? $item->schedules->count() : 0],
                ['teacher' => $item->teacher ? $item->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName', 'photoURL']) : null],
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null],
                ['updater' => $item->updater ? $item->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
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
            'sectionId' => 'required|string',
            'planCourseId' => 'required|string',
            'teacherId' => 'nullable|string',
        ]);

        $already = SectionCourse::where('planCourseId', $req->planCourseId)
            ->where('sectionId', $req->sectionId)->first();

        if ($already) return response()->json('already_exists', 400);

        $data = SectionCourse::create([
            'sectionId' => $req->sectionId,
            'planCourseId' => $req->planCourseId,
            'teacherId' => $req->teacherId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'sectionId' => 'required|string',
            'planCourseId' => 'required|string',
            'teacherId' => 'nullable|string',
        ]);

        $item = SectionCourse::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = SectionCourse::where('planCourseId', $req->planCourseId)
            ->where('sectionId', $req->sectionId)
            ->where('id', '!=', $id)->first();

        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'sectionId' => $req->sectionId,
            'planCourseId' => $req->planCourseId,
            'teacherId' => $req->teacherId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = SectionCourse::find($id);

        SectionCourseSchedule::where('sectionCourseId', $id)->delete();

        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = SectionCourse::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            array_merge(
                $data->only(keys: ['id', 'created_at']),
                ['section' => $data->section ? $data->section->only(['id', 'code', 'details']) : null],
                ['planCourse' => $data->planCourse ? $data->planCourse->only(['id', 'name', 'credits', 'teoricHours', 'practiceHours']) + [
                    'course' => $data->planCourse->course ? $data->planCourse->course->only(['id', 'code', 'name']) : null,
                    'plan' => $data->planCourse->plan ? $data->planCourse->plan->only(['id', 'name']) : null,
                ] : null],
                ['teacher' => $data->teacher ? $data->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null],
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null],
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
            )
        );
    }

    public function schedules(Request $req, $id)
    {
        $teacherId = $req->query('teacherId');
        $sectionId = $req->query('sectionId');

        $tu = UserSchedule::where('userId', $teacherId)->where('type', 'unavailable')->get();

        $ss = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($sectionId) {
            $query->where('sectionId', $sectionId);
        })
            ->get();

        $ts = SectionCourseSchedule::whereHas('sectionCourse', function ($query) use ($teacherId) {
            $query->where('teacherId', $teacherId);
        })
            ->whereNotIn('id', $ss->pluck('id'))
            ->get();



        return response()->json([
            'teacherUnavailables' => $tu->map(function ($schedule) {
                return array_merge(
                    $schedule->only(['id', 'startDate', 'endDate', 'days', 'from', 'to']),
                    ['dates' => $schedule->dates]
                );
            }),
            'sectionSchedules' => $ss->map(function ($item) {
                return array_merge(
                    $item->only(['id', 'startTime', 'endTime', 'startDate', 'daysOfWeek', 'endDate']),
                    ['program' => $item->sectionCourse?->section?->program?->only(['id', 'name']) + [
                        'businessUnit' => $item->sectionCourse?->section?->program?->businessUnit?->only(['id', 'logoURLSquare']),
                    ]],
                    ['sectionCourse' => [
                        'teacher' => $item->sectionCourse->teacher ? $item->sectionCourse->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null,
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
            }),
            'teacherSchedules' => $ts->map(function ($item) {
                return array_merge(
                    $item->only(['id', 'startTime', 'endTime', 'startDate', 'daysOfWeek', 'endDate']),
                    ['program' => $item->sectionCourse?->section?->program?->only(['id', 'name']) + [
                        'businessUnit' => $item->sectionCourse?->section?->program?->businessUnit?->only(['id', 'logoURLSquare']),
                    ]],
                    ['sectionCourse' => [
                        'teacher' => $item->sectionCourse->teacher ? $item->sectionCourse->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null,
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
            }),
        ]);
    }
}
