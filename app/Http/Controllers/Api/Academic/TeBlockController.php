<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeBlockController extends Controller
{
    public function index(Request $req)
    {
        $match = TeBlock::orderBy('order', 'asc');
        $q = $req->query('q');
        $categoryId = $req->query('categoryId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($categoryId) $match->where('categoryId', $categoryId);

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
            'categoryId' => 'required|string',
            'name' => 'required|string',
            'order' => 'required|integer',
        ]);
        $already = TeBlock::where('name', $req->name)->where('categoryId', $req->categoryId)->first();
        if ($already) return response()->json('already_exists', 400);
        $data = TeBlock::create([
            'name' => $req->name,
            'order' => $req->order,
            'categoryId' => $req->categoryId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'categoryId' => 'required|string',
            'name' => 'required|string',
            'order' => 'required|integer',
        ]);
        $item = TeBlock::find($id);
        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);
        $already = TeBlock::where('name', $req->name)->where('id', '!=', $id)->where('categoryId', $req->categoryId)->first();
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
        $data = TeBlock::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = TeBlock::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'order', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
