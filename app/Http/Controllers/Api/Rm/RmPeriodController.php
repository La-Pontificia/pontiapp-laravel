<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\RmPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RmPeriodController extends Controller
{
    public function index(Request $req)
    {
        $match = RmPeriod::orderBy('name', 'desc');
        $q = $req->query('q');
        $periodId = $req->query('periodId');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($periodId) $match->where('periodId', $periodId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'created_at']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['academicProgram' => $item->academicProgram ? $item->academicProgram->only(['id', 'name']) + [
                    'businessUnit' => $item->academicProgram->businessUnit ? $item->academicProgram->businessUnit->only(['id', 'name']) : null
                ] : null];
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
            'academicProgramId' => 'required|exists:rm_academic_programs,id',
        ]);
        $data = RmPeriod::create([
            'name' => $req->name,
            'academicProgramId' => $req->academicProgramId,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'academicProgramId' => 'required|exists:rm_academic_programs,id',
        ]);

        $item = RmPeriod::find($id);

        $item->update([
            'name' => $req->name,
            'academicProgramId' => $req->academicProgramId,
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = RmPeriod::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
