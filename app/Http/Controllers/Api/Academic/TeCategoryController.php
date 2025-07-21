<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeCategoryController extends Controller
{
    public function index(Request $req)
    {
        $match = TeCategory::orderBy('order', 'asc');
        $q = $req->query('q');
        $groupId = $req->query('groupId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($groupId) $match->where('groupId', $groupId);

        $data = $paginate ? $match->paginate(25) :  $match->get();
        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'order', 'created_at']);
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
            'groupId' => 'required|string',
            'name' => 'required|string',
            'order' => 'required|integer',
        ]);
        $already = TeCategory::where('name', $req->name)->where('groupId', $req->groupId)->first();
        if ($already) return response()->json('already_exists', 400);
        $data = TeCategory::create([
            'name' => $req->name,
            'order' => $req->order,
            'groupId' => $req->groupId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'groupId' => 'required|string',
            'name' => 'required|string',
            'order' => 'required|integer',
        ]);
        $item = TeCategory::find($id);
        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);
        $already = TeCategory::where('name', $req->name)->where('id', '!=', $id)->where('groupId', $req->groupId)->first();
        if ($already) return response()->json('already_exists', 400);
        $item->update([
            'name' => $req->name,
            'order' => $req->order,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = TeCategory::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = TeCategory::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'order', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
