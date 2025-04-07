<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Pavilion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PavilionController extends Controller
{
    public function index(Request $req)
    {
        $match = Pavilion::orderBy('name', 'asc');
        $q = $req->query('q');

        $paginate = $req->query('paginate') === 'true';
        $periodId = $req->query('periodId');

        if ($q) $match->where('name', 'like', "%$q%");
        if ($periodId) $match->where('periodId', $periodId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'created_at']) +
                ['period' => $item->period ? $item->period->only(['id', 'name']) : null] +
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
            'periodId' => 'required|string',
        ]);

        $already = Pavilion::where('name', $req->name)->first();
        if ($already) return response()->json('already_exists', 400);

        $data = Pavilion::create([
            'name' => $req->name,
            'periodId' => $req->periodId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'periodId' => 'required|string',
        ]);

        $item = Pavilion::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = Pavilion::where('name', $req->name)->where('id', '!=', $id)->first();
        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'name' => $req->name,
            'periodId' => $req->periodId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Pavilion::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Pavilion::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'created_at']) +
                ['period' => $data->period ? $data->period->only(['id', 'name']) : null] +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
