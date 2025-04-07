<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $req)
    {
        $match = Course::orderBy('code', 'asc');
        $q = $req->query('q');
        $businessUnitId = $req->query('businessUnitId');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")->orWhere('code', 'like', "%$q%");
        if ($businessUnitId) $match->where('businessUnitId', $businessUnitId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'code', 'teoricHours', 'practiceHours', 'credits', 'created_at']) +
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
            'code' => 'required|string',
            'name' => 'required|string',
            'businessUnitId' => 'required|string',
            'teoricHours' => 'nullable|numeric',
            'practiceHours' => 'nullable|numeric',
            'credits' => 'nullable|numeric',
        ]);

        $course = Course::where('code', $req->code)->first();
        if ($course) return response()->json('already_exists', 400);

        $data = Course::create([
            'code' => $req->code,
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
            'teoricHours' => $req->teoricHours,
            'practiceHours' => $req->practiceHours,
            'credits' => $req->credits,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'businessUnitId' => 'required|string',
            'teoricHours' => 'nullable|numeric',
            'practiceHours' => 'nullable|numeric',
            'credits' => 'nullable|numeric',
        ]);


        $course = Course::where('code', $req->code)->where('id', '!=', $id)->first();

        if ($course) return response()->json('already_exists', 400);

        $item = Course::find($id);

        $item->update([
            'code' => $req->code,
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
            'teoricHours' => $req->teoricHours,
            'practiceHours' => $req->practiceHours,
            'credits' => $req->credits,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Course::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Course::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'code', 'teoricHours', 'practiceHours', 'credits', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
