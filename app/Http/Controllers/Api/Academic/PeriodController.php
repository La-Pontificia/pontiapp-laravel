<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\Classroom;
use App\Models\Academic\Pavilion;
use App\Models\Academic\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodController extends Controller
{
    public function index(Request $req)
    {
        $match = Period::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $businessUnitId = $req->query('businessUnitId');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%");
        if ($businessUnitId) $match->where('businessUnitId', $businessUnitId);

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'startDate', 'endDate', 'created_at']) +
                ['businessUnit' => $item->businessUnit ? $item->businessUnit->only(['id', 'name']) : null] +
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
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'businessUnitId' => 'required|string',
            'cloneByPeriodId' => 'nullable|string',
        ]);


        $period = Period::where('name', $req->name)
            ->where('businessUnitId', $req->businessUnitId)

            ->first();
        if ($period) return response()->json('already_exists', 400);

        $data = Period::create([
            'name' => $req->name,
            'startDate' => $req->startDate,
            'endDate' => $req->endDate,
            'businessUnitId' => $req->businessUnitId,
            'creatorId' => Auth::id(),
        ]);

        if ($req->cloneByPeriodId) {
            Pavilion::where('periodId', $req->cloneByPeriodId)->get()->each(function ($pavilion) use ($data) {
                $newPavilion = Pavilion::create([
                    'name' => $pavilion->name,
                    'periodId' => $data->id,
                    'creatorId' => Auth::id(),
                ]);
                Classroom::where('pavilionId', $pavilion->id)->get()->each(function ($classroom) use ($newPavilion) {
                    Classroom::create([
                        'code' => $classroom->code,
                        'floor' => $classroom->floor,
                        'details' => $classroom->details,
                        'capacity' => $classroom->capacity,
                        'pavilionId' => $newPavilion->id,
                        'creatorId' => Auth::id(),
                    ]);
                });
            });
        }

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'businessUnitId' => 'required|string',
        ]);

        $item = Period::find($id);

        // validate if the period exists
        if (!$item) return response()->json('not_found', 404);

        $period = Period::where('name', $req->name)->where('id', '!=', $id)
            ->where('businessUnitId', $req->businessUnitId)
            ->first();

        if ($period) return response()->json('already_exists', 400);

        $item->update([
            'name' => $req->name,
            'startDate' => $req->startDate,
            'endDate' => $req->endDate,
            'businessUnitId' => $req->businessUnitId,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Updated');
    }

    public function delete($id)
    {
        $data = Period::find($id);
        if (!$data) return response()->json('not_found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $data = Period::find($id);
        if (!$data) return response()->json('Data not found', 404);
        return response()->json(
            $data->only(['id', 'name', 'startDate', 'endDate', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
