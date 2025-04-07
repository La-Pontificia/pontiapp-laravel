<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CycleController extends Controller
{
    public function index(Request $req)
    {
        $match = Cycle::orderBy('created_at', 'asc');
        $q = $req->query('q');
        $programId = $req->query('programId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('code', 'like', "%$q%")->orWhere('name', 'like', "%$q%");
        if ($programId) $match->where('programId', $programId);

        $data = $paginate ? $match->paginate(25) :  $match->get();


        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'code', 'name', 'created_at']) +
                ['program' => $item->program ? $item->program->only(['id', 'name']) : null] +
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
            'programId' => 'required|string',
        ]);

        $already = Cycle::where('code', $req->code)->where('programId', $req->programId)->first();
        if ($already) return response()->json('already_exists', 400);

        $data = Cycle::create([
            'code' => $req->code,
            'name' => $req->name,
            'programId' => $req->programId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'programId' => 'required|string',
        ]);

        $item = Cycle::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = Cycle::where('code', $req->code)->where('id', '!=', $id)->first();
        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'code' => $req->code,
            'name' => $req->name,
            'programId' => $req->programId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Cycle::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Cycle::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'code', 'name', 'created_at']) +
                ['program' => $data->program ? $data->program->only(['id', 'name']) : null] +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
