<?php

namespace App\Http\Controllers\Api\Attention;

use App\Http\Controllers\Controller;
use App\Models\AttentionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttentionServiceController extends Controller
{
    public function all(Request $req)
    {
        $match = AttentionService::orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('shortName', 'like', "%$q%");

        if (in_array('creator', $relationship)) $match->with('creator');
        if (in_array('updater', $relationship)) $match->with('updater');
        if (in_array('position', $relationship)) $match->with('position');
        if (in_array('position.business', $relationship)) $match->with('position.business');

        $positions = $paginate === 'true' ? $match->paginate() : $match->get();

        return response()->json($positions);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'attentionPositionId' => 'required|uuid',
        ]);

        $position = AttentionService::create([
            'name' => $req->name,
            'attentionPositionId' => $req->attentionPositionId,
            'creatorId' => Auth::id(),
        ]);

        return response()->json($position);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'attentionPositionId' => 'required|uuid',
        ]);

        $position = AttentionService::findOrFail($id);
        $position->update([
            'name' => $req->name,
            'attentionPositionId' => $req->attentionPositionId,
            'updaterId' => Auth::id(),
        ]);

        return response()->json($position);
    }

    public function delete(Request $req, $id)
    {
        $position = AttentionService::findOrFail($id);
        $position->delete();

        return response()->json($position);
    }

    public function byBusiness($businessId)
    {
        $services = AttentionService::whereHas('position', function ($q) use ($businessId) {
            $q->where('businessUnitId', $businessId);
        })->get();

        return response()->json($services);
    }
}