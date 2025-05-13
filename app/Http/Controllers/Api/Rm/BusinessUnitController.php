<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\Rm\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessUnitController extends Controller
{
    public function index(Request $req)
    {
        $match = BusinessUnit::orderBy('created_at', 'desc');
        $q = $req->query('q');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere("acronym", "like", "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'acronym', 'logoURL', 'logoURLSquare', 'domain', 'created_at']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null];
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
            'acronym' => 'required|string',
            'domain' => 'required|string',

        ]);

        $already = BusinessUnit::where('name', $req->name)->first();
        if ($already) return response()->json('already_exists', 400);

        $data = BusinessUnit::create([
            'name' => $req->name,
            'acronym' => $req->acronym,
            'domain' => $req->domain,
            'creatorId' => Auth::id(),
        ]);

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'acronym' => 'required|string',
            'domain' => 'required|string',
        ]);

        $item = BusinessUnit::find($id);

        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);

        $already = BusinessUnit::where('name', $req->name)->where('id', '!=', $id)->first();

        if ($already) return response()->json('already_exists', 400);

        $item->update([
            'name' => $req->name,
            'acronym' => $req->acronym,
            'domain' => $req->domain,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        return response()->json('not_found', 404);
    }

    public function one($id)
    {
        $data = BusinessUnit::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'acronym', 'logoURL', 'logoURLSquare', 'domain', ' created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]

        );
    }
}
