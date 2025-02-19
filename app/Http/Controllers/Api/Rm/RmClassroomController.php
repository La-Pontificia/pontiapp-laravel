<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\RmRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RmClassroomController extends Controller
{
    public function index(Request $req)
    {
        $match = RmRoom::orderBy('name', 'desc');
        $q = $req->query('q');
        if ($q) $match->where('name', 'like', "%$q%");
        $data = $match->limit(5)->get();
        return response()->json($data);
    }

    public function store(Request $req)
    {
        $req->validate(['name' => 'required|string|unique:rm_classroom',]);
        $data = RmRoom::create([
            'name' => $req->name,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = RmRoom::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
