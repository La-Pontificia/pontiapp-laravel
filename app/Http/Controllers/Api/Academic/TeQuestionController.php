<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeQuestionController extends Controller
{
    public function index(Request $req)
    {
        $match = TeQuestion::orderBy('order', 'asc');
        $q = $req->query('q');
        $blockId = $req->query('blockId');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('question', 'like', "%$q%");
        if ($blockId) $match->where('blockId', $blockId);

        $data = $paginate ? $match->paginate(25) :  $match->get();
        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'question', 'order', 'type', 'created_at']);
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
            'blockId' => 'required|string',
            'question' => 'required|string',
            'type' => 'required|string',
            'order' => 'required|integer',
        ]);
        $already = TeQuestion::where('question', $req->question)->where('blockId', $req->blockId)->first();
        if ($already) return response()->json('already_exists', 400);
        $data = TeQuestion::create([
            'question' => $req->question,
            'type' => $req->type,
            'order' => $req->order,
            'blockId' => $req->blockId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'question' => 'required|string',
            'type' => 'required|string',
            'order' => 'required|integer',
        ]);
        $item = TeQuestion::find($id);
        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);
        $already = TeQuestion::where('question', $req->question)->where('id', '!=', $id)->where('blockId', $req->blockId)->first();
        if ($already) return response()->json('already_exists', 400);
        $item->update([
            'question' => $req->question,
            'type' => $req->type,
            'order' => $req->order,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = TeQuestion::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = TeQuestion::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'question', 'order', 'type', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
