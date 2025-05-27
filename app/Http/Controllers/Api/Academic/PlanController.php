<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index(Request $req)
    {
        $match = Plan::orderBy('name', 'desc');
        $q = $req->query('q');
        $programId = $req->query('programId');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($programId) $match->where('programId', $programId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'pontisisCode', 'created_at', 'status']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['program' => $item->program ? $item->program->only(['id', 'name']) + [
                    'businessUnit' => $item->program->businessUnit ? $item->program->businessUnit->only(['id', 'name', 'acronym', 'logoURL']) : null
                ] : null];
        });

        return response()->json(
            $paginate ? [
                ...$data->toArray(),
                'data' => $graphed,
            ] : $graphed
        );
    }

    public function one($slug)
    {
        $data = Plan::find($slug);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'pontisisCode', 'created_at', 'status']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['program' => $data->program ? $data->program->only(['id', 'name']) + [
                    'businessUnit' => $data->program->businessUnit ? $data->program->businessUnit->only(['id', 'name', 'acronym', 'logoURL']) : null
                ] : null]
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'pontisisCode' => 'required|string',
            'name' => 'required|string|unique:academic_plans',
            'programId' => 'required|exists:academic_programs,id',
            'status' => 'nullable|boolean',
        ]);
        Plan::create([
            'name' => $req->name,
            'pontisisCode' => $req->pontisisCode,
            'programId' => $req->programId,
            'status' => $req->status ?? true,
            'creatorId' => Auth::id(),
        ]);
        return response()->json('Ok');
    }

    public function update(Request $req, $id)
    {
        $found = Plan::find($id);
        if (!$found) return response()->json('not_found', 404);

        $req->validate([
            'pontisisCode' => 'required|string',
            'name' => 'required|string',
            'programId' => 'required|exists:academic_programs,id',
            'status' => 'nullable|boolean',
        ]);

        $already = Plan::where('name', $req->name)->where('id', '!=', $id)->first();
        if ($already) return response()->json('already_exists', 400);

        $found->update([
            'pontisisCode' => $req->pontisisCode,
            'name' => $req->name,
            'programId' => $req->programId,
            'status' => $req->status ?? true,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Ok');
    }

    public function delete($id)
    {
        $data = Plan::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
