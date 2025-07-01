<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\PlanCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanCourseController extends Controller
{
    public function index(Request $req)
    {
        $match = PlanCourse::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $planId = $req->query('planId');
        $cycleId = $req->query('cycleId');
        $status = $req->query('status');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->whereHas('course', function ($query) use ($q) {
            $query->where('code', 'like', "%$q%")->orWhere('name', 'like', "%$q%");
        });

        if ($cycleId) $match->where('cycleId', $cycleId);

        if ($planId) $match->where('planId', $planId);
        if ($status === 'true') $match->where('status', true);
        if ($status === 'false') $match->where('status', false);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'formula', 'credits', 'teoricHours', 'practiceHours', 'status', 'created_at']) +
                ['course' => $item->course ? $item->course->only(['id', 'code', 'name']) : null] +
                ['plan' => $item->plan ? $item->plan->only(['id', 'name']) : null] +
                ['cycle' => $item->cycle ? $item->cycle->only(['id', 'code', 'name']) : null] +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $item->updater ? $item->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null];
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
            'name' => 'required|string',
            'planId' => 'required|string',
            'courseId' => 'required|string',
            'cycleId' => 'required|string',
            'credits' => 'required|numeric',
            'teoricHours' => 'required|numeric',
            'practiceHours' => 'required|numeric',
            'formula' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $already = PlanCourse::whereHas('course', function ($query) use ($req) {
            $query->where('id', $req->courseId);
        })->where('planId', $req->planId)->where('cycleId', $req->cycleId)->first();

        if ($already) return response()->json('already_exists', 400);

        $data = PlanCourse::create([
            'name' => $req->name,
            'planId' => $req->planId,
            'courseId' => $req->courseId,
            'cycleId' => $req->cycleId,
            'credits' => $req->credits,
            'teoricHours' => $req->teoricHours,
            'practiceHours' => $req->practiceHours,
            'status' => $req->status,
            'formula' => $req->formula,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'planId' => 'required|string',
            'courseId' => 'required|string',
            'cycleId' => 'required|string',
            'credits' => 'required|numeric',
            'teoricHours' => 'required|numeric',
            'practiceHours' => 'required|numeric',
            'formula' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $item = PlanCourse::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = PlanCourse::whereHas('course', function ($query) use ($req) {
            $query->where('id', $req->courseId);
        })
            ->where('planId', $req->planId)
            ->where('cycleId', $req->cycleId)
            ->where('id', '!=', $id)->first();


        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'name' => $req->name,
            'planId' => $req->planId,
            'courseId' => $req->courseId,
            'formula' => $req->formula,
            'cycleId' => $req->cycleId,
            'credits' => $req->credits,
            'teoricHours' => $req->teoricHours,
            'practiceHours' => $req->practiceHours,
            'status' => $req->status,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = PlanCourse::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = PlanCourse::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'credits', 'formula', 'teoricHours', 'practiceHours', 'status', 'created_at']) +
                ['course' => $data->course ? $data->course->only(['id', 'code']) : null] +
                ['plan' => $data->plan ? $data->plan->only(['id', 'name']) : null] +
                ['cycle' => $data->cycle ? $data->cycle->only(['id', 'code', 'name']) : null] +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }

    public function status($id)
    {
        $item = PlanCourse::find($id);
        if (!$item) return response()->json('Data not found', 404);
        $item->update([
            'status' => !$item->status,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Status updated');
    }
}
