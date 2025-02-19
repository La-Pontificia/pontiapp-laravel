<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\RmAcademicProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RmAcademicProgramController extends Controller
{
    public function index(Request $req)
    {
        $match = RmAcademicProgram::orderBy('created_at', 'desc');
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

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'businessUnitId' => 'required|exists:rm_business_units,id',
        ]);
        $data = RmAcademicProgram::create([
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json('Created');
    }


    public function update(Request $req, $id)
    {
        $req->validate(['name' => 'required|string', 'businessUnitId' => 'required|exists:rm_business_units,id',]);

        $item = RmAcademicProgram::find($id);

        $item->update([
            'name' => $req->name,
            'businessUnitId' => $req->businessUnitId,
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = RmAcademicProgram::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
