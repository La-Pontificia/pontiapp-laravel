<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\SectionCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionCourseController extends Controller
{
    public function index(Request $req)
    {
        $match = SectionCourse::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $sectionId = $req->query('sectionId');
        $programId = $req->query('programId');
        $periodId = $req->query('periodId');
        $courseId = $req->query('courseId');
        $teacherId = $req->query('teacherId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->whereHas('section', function ($query) use ($q) {
            $query->where('code', 'like', "%$q%");
        })->orWhereHas('planCourse', function ($query) use ($q) {
            $query->whereHas('course', function ($query) use ($q) {
                $query->where('code', 'like', "%$q%")
                    ->orWhere('name', 'like', "%$q%");
            });
        })->orWhereHas('teacher', function ($query) use ($q) {
            $query->where('username', 'like', "%$q%")
                ->orWhere('firstNames', 'like', "%$q%")
                ->orWhere('documentId', 'like', "%$q%")
                ->orWhere('lastNames', 'like', "%$q%")
                ->orWhere('displayName', 'like', "%$q%");
        });

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
                ['teacher' => $item->teacher ? $item->teacher->only(['id', 'firstNames', 'fullName', 'documentId', 'lastNames', 'displayName']) : null],
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
                $data->only(['id', 'created_at']),
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
}
