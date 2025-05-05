<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Academic\Section;
use App\Models\Academic\SectionCourse;
use App\Models\User\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index(Request $req)
    {
        $match = Team::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")->orWhere('description', 'like', "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return array_merge(
                $item->only(['id', 'name', 'description', 'created_at']),
                ['members' => $item->members->map(function ($member) {
                    return array_merge(
                        $member->user->only(['id', 'photoURL', 'firstNames', 'lastNames', 'displayName']),
                        ['type' => $member->type]
                    );
                })],
                ['membersCount' => $item->members->count()],
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null],
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
