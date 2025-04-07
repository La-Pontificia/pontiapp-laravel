<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index(Request $req)
    {
        $match = Classroom::orderBy('code', 'asc');
        $q = $req->query('q');
        $pavilionId = $req->query('pavilionId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('code', 'like', "%$q%")->orWhere('type', 'like', "%$q%");
        if ($pavilionId) $match->where('pavilionId', $pavilionId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'code', 'type', 'floor', 'capacity', 'created_at']) +
                ['pavilion' => $item->pavilion ? $item->pavilion->only(['id', 'name']) : null] +
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
            'type' => 'required|string',
            'floor' => 'nullable|numeric',
            'capacity' => 'nullable|numeric',
            'pavilionId' => 'required|string',
        ]);

        $already = Classroom::where('code', $req->code)->where('pavilionId', $req->pavilionId)->first();
        if ($already) return response()->json('already_exists', 400);

        $data = Classroom::create([
            'code' => $req->code,
            'type' => $req->type,
            'capacity' => $req->capacity,
            'floor' => $req->floor,
            'pavilionId' => $req->pavilionId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'code' => 'required|string',
            'type' => 'required|string',
            'floor' => 'nullable|numeric',
            'capacity' => 'nullable|numeric',
            'pavilionId' => 'required|string',
        ]);

        $item = Classroom::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = Classroom::where('code', $req->name)->where('id', '!=', $id)->first();
        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'code' => $req->code,
            'type' => $req->type,
            'floor' => $req->floor,
            'capacity' => $req->capacity,
            'pavilionId' => $req->pavilionId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Classroom::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Classroom::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'code', 'type', 'floor', 'capacity', 'created_at']) +
                ['pavilion' => $data->pavilion ? $data->pavilion->only(['id', 'name']) : null] +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
