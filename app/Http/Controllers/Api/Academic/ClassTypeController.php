<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassTypeController extends Controller
{
    public function index(Request $req)
    {
        $match = ClassType::orderBy('name', 'asc');
        $q = $req->query('q');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")->orWhere('pontisisCode', 'like', "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'pontisisCode', 'created_at']) +
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
            'pontisisCode' => 'required|string',
        ]);

        $already = ClassType::where('name', $req->name)->first();
        if ($already) return response()->json('already_exists', 400);

        $data = ClassType::create([
            'name' => $req->name,
            'pontisisCode' => $req->pontisisCode,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'pontisisCode' => 'required|string',
        ]);

        $item = ClassType::find($id);
        if (!$item) return response()->json('not_found', 404);

        $already = ClassType::where('name', $req->name)->where('id', '!=', $id)->first();
        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'name' => $req->name,
            'pontisisCode' => $req->pontisisCode,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = ClassType::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = ClassType::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'pontisisCode', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
