<?php

namespace App\Http\Controllers\Api\Attention;

use App\Http\Controllers\Controller;
use App\Models\Attention;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttentionController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->get('q');
        $positionId = $req->get('positionId');
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');

        $businessUnitId = $req->get('businessUnitId');
        $relationShip = $req->get('relationship') ? explode(',', $req->get('relationship')) : [];

        $query = Attention::orderBy('created_at', 'desc');

        // if ($startDate) {
        //     $query->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $startDate));
        // }

        // if ($endDate) {
        //     $query->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $endDate));
        // }

        if ($q) {
            $query->where('personFirstnames', 'like', "%$q%")
                ->orWhere('personLastnames', 'like', "%$q%")
                ->orWhere('personCareer', 'like', "%$q%")
                ->orWhere('personPeriodName', 'like', "%$q%")
                ->orWhere('personEmail', 'like', "%$q%")
                ->orWhere('attentionDescripcion', 'like', "%$q%");
        }

        if ($positionId) {
            $query->where('attentionPositionId', $positionId);
        }

        if ($businessUnitId) {
            $query->whereHas('position', function ($q) use ($businessUnitId) {
                $q->where('businessUnitId', $businessUnitId);
            });
        }

        if (in_array('position', $relationShip)) {
            $query->with('position');
        }

        if (in_array('position.business', $relationShip)) {
            $query->with('position.business');
        }

        if (in_array('attendant', $relationShip)) {
            $query->with('attendant');
        }

        $attentions = $query->paginate();

        $data = $attentions->map(function ($attention) {
            return $attention->only(['id', 'personFirstnames', 'personLastnames', 'personDocumentId', 'startAttend', 'finishAttend', 'created_at']) + [
                'attendant' => $attention->attendant ? $attention->attendant->only(['id', 'firstNames', 'lastNames', 'photoURL', 'displayName', 'username']) : null,
                'position' => $attention->position ? $attention->position->only(['id', 'name', 'shortName']) + [
                    'business' => $attention->position->business ? $attention->position->business->only(['id', 'name']) : null,
                ] : null,
            ];
        });

        return response()->json(
            [
                'data' => $data,
                'from' => $attentions->firstItem(),
                'to' => $attentions->lastItem(),
                'total' => $attentions->total(),
                'current_page' => $attentions->currentPage(),
                'last_page' => $attentions->lastPage(),
            ]
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'attentionPositionId' => 'required|uuid',
            'personDocumentId' => 'required|string',
            'personFirstnames' => 'required|string',
            'personLastnames' => 'required|string',
            'personCareer' => 'nullable|string',
            'personPeriodName' => 'nullable|string',
            'personGender' => 'nullable|string',
            'personEmail' => 'nullable|email',
            'startAttend' => 'required|date',
            'finishAttend' => 'required|date',
        ]);

        Attention::create([
            'attentionPositionId' => $req->get('attentionPositionId'),
            'attendantId' => Auth::id(),
            'personDocumentId' => $req->get('personDocumentId'),
            'personFirstnames' => $req->get('personFirstnames'),
            'personLastnames' => $req->get('personLastnames'),
            'personCareer' => $req->get('personCareer'),
            'personPeriodName' => $req->get('personPeriodName'),
            'personGender' => $req->get('personGender'),
            'personEmail' => $req->get('personEmail'),
            'startAttend' => Carbon::parse($req->get('startAttend')),
            'finishAttend' => Carbon::parse($req->get('finishAttend')),
        ]);

        return response()->json([
            'message' => 'Attention created successfully',
        ]);
    }

    public function update(Request $req, $id) {}

    public function destroy($id) {}
}
