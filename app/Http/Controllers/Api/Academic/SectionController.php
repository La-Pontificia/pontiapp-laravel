<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\PlanCourse;
use App\Models\Academic\Section;
use App\Models\Academic\SectionCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(Request $req)
    {
        $match = Section::orderBy('code', 'asc');
        $q = $req->query('q');
        $programId = $req->query('programId');
        $periodId = $req->query('periodId');
        $cycleId = $req->query('cycleId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('code', 'like', "%$q%")->orWhere('details', 'like', "%$q%");
        if ($programId) $match->where('programId', $programId);
        if ($periodId) $match->where('periodId', $periodId);
        if ($cycleId) $match->where('cycleId', $cycleId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return array_merge(
                $item->only(['id', 'code', 'details', 'created_at']),
                ['cycle' => $item->cycle ? $item->cycle->only(['id', 'code', 'name']) : null],
                ['plan' => $item->plan ? $item->plan->only(['id', 'name']) : null],
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
            'code' => 'required|string',
            'planId' => 'required|string',
            'programId' => 'required|string',
            'periodId' => 'required|string',
            'coursesIds' => 'nullable|array',
            'cycleId' => 'required|string',
        ]);

        $already = Section::where('code', $req->code)
            ->where('programId', $req->programId)
            ->where('periodId', $req->periodId)
            ->where('cycleId', $req->cycleId)->first();

        if ($already) return response()->json('already_exists', 400);

        $data = Section::create([
            'code' => $req->code,
            'planId' => $req->planId,
            'programId' => $req->programId,
            'periodId' => $req->periodId,
            'cycleId' => $req->cycleId,
            'creatorId' => Auth::id(),
        ]);

        foreach ($req->coursesIds as $courseId) {
            SectionCourse::create([
                'sectionId' => $data->id,
                'planCourseId' => $courseId,
                'planId' => $req->planId,
                'creatorId' => Auth::id(),
            ]);
        }

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'code' => 'required|string',
            'planId' => 'required|string',
            'programId' => 'required|string',
            'periodId' => 'required|string',
            'cycleId' => 'required|string',
        ]);


        $item = Section::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = Section::where('code', $req->code)
            ->where('programId', $req->programId)
            ->where('periodId', $req->periodId)
            ->where('cycleId', $req->cycleId)
            ->where('id', '!=', $id)->first();

        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'code' => $req->code,
            'planId' => $req->planId,
            'programId' => $req->programId,
            'periodId' => $req->periodId,
            'cycleId' => $req->cycleId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Section::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Section::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            array_merge(
                $data->only(['id', 'code', 'details', 'created_at']),
                ['cycle' => $data->cycle ? $data->cycle->only(['id', 'code', 'name']) : null],
                ['plan' => $data->plan ? $data->plan->only(['id', 'name']) : null],
                ['program' => $data->program ? $data->program->only(['id', 'name']) : null],
                ['period' => $data->period ? $data->period->only(['id', 'code', 'name']) : null],
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null],
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
            )
        );
    }
}
