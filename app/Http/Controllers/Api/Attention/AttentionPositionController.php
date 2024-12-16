<?php

namespace App\Http\Controllers\Api\Attention;

use App\Http\Controllers\Controller;
use App\Models\AttentionPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttentionPositionController extends Controller
{
    public function all(Request $req)
    {
        $match = AttentionPosition::orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('shortName', 'like', "%$q%");

        if (in_array('creator', $relationship)) $match->with('creator');
        if (in_array('updater', $relationship)) $match->with('updater');
        if (in_array('business', $relationship)) $match->with('business');
        if (in_array('current', $relationship)) $match->with('current');

        $positions = $paginate === 'true' ? $match->paginate() : $match->get();

        return response()->json($positions);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'shortName' => 'required|string',
            'businessUnitId' => 'required|uuid',
        ]);

        $position = AttentionPosition::create([
            'name' => $req->name,
            'shortName' => $req->shortName,
            'available' => $req->available ? true : false,
            'businessUnitId' => $req->businessUnitId,
            'creatorId' => Auth::id(),
        ]);

        return response()->json($position);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'shortName' => 'required|string',
            'businessUnitId' => 'required|uuid',
        ]);

        $position = AttentionPosition::findOrFail($id);
        $position->update([
            'name' => $req->name,
            'shortName' => $req->shortName,
            'available' => $req->available ? true : false,
            'businessUnitId' => $req->businessUnitId,
            'updaterId' => Auth::id(),
        ]);

        return response()->json($position);
    }

    public function delete(Request $req, $id)
    {
        $position = AttentionPosition::findOrFail($id);
        $position->delete();

        return response()->json($position);
    }
}
