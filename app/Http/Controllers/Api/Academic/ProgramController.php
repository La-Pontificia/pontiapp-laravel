<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $req)
    {
        $match = Program::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $businessUnitId = $req->query('businessUnitId');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($businessUnitId) $match->where('businessUnitId', $businessUnitId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'created_at']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['businessUnit' => $item->businessUnit ? $item->businessUnit->only(['id', 'name', 'acronym', 'logoURL']) : null];
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
        $data = Program::find($slug);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['businessUnit' => $data->businessUnit ? $data->businessUnit->only(['id', 'name', 'acronym', 'logoURL']) : null]
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'businessUnitId' => 'required|exists:rm_business_units,id',
        ]);
        $data = Program::create([
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json('Created');
    }


    public function update(Request $req, $id)
    {
        $req->validate(['name' => 'required|string', 'businessUnitId' => 'required|exists:rm_business_units,id',]);

        $item = Program::find($id);

        $item->update([
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Program::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
