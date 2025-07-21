<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeOptionController extends Controller
{
    public function index(Request $req)
    {
        $match = TeOption::orderBy('order', 'asc');
        $q = $req->query('q');
        $questionId = $req->query('questionId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($questionId) $match->where('questionId', $questionId);

        $data = $paginate ? $match->paginate(25) :  $match->get();
        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'value', 'order', 'created_at']);
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
            'questionId' => 'required|string',
            'name' => 'required|string',
            'value' => 'required|integer',
            'order' => 'required|integer',
        ]);
        $already = TeOption::where('name', $req->name)->where('questionId', $req->questionId)->first();
        if ($already) return response()->json('already_exists', 400);
        $data = TeOption::create([
            'questionId' => $req->questionId,
            'name' => $req->name,
            'value' => $req->value,
            'order' => $req->order,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'value' => 'required|integer',
            'order' => 'required|integer',
        ]);
        $item = TeOption::find($id);
        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);
        $already = TeOption::where('name', $req->name)->where('id', '!=', $id)->where('questionId', $req->questionId)->first();
        if ($already) return response()->json('already_exists', 400);
        $item->update([
            'name' => $req->name,
            'value' => $req->value,
            'order' => $req->order,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = TeOption::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = TeOption::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'order', 'value', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
