<?php

namespace App\Http\Controllers\Api\Area;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function all(Request $req)
    {
        $match = Area::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%");
        if (in_array('departments', $relationship)) $match->with('departments');

        $areas = $match->get();

        return response()->json($areas);
    }
    public function create(Request $req)
    {

        $req->validate([
            'codePrefix' => 'required|string',
            'name' => 'required|string',
        ]);

        $area = new Area();
        $area->codePrefix = $req->codePrefix;
        $area->name = $req->name;
        $area->createdBy = Auth::id();
        $area->save();

        return response()->json($area);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'codePrefix' => 'required|string',
            'name' => 'required|string',
        ]);

        $area = Area::find($id);
        $area->codePrefix = $req->codePrefix;
        $area->name = $req->name;
        $area->updatedBy = Auth::id();
        $area->save();

        return response()->json($area);
    }

    public function delete($id)
    {
        $area = Area::find($id);

        if ($area->departments()->count() > 0) {
            return response()->json('Hay departamentos asociados a esta área, por favor transfiera y vuelve a internarlo.', 400);
        }

        $area->delete();

        return response()->json(['message' => 'Area deleted']);
    }
}
