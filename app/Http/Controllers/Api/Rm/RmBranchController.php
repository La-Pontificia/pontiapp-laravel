<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\RmBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RmBranchController extends Controller
{
    public function index(Request $req)
    {
        $match = RmBranch::orderBy('name', 'desc');
        $q = $req->query('q');
        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('address', 'like', "%$q%");
        $data = $match->limit(5)->get();
        return response()->json($data);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|unique:rm_branches',
            'address' => 'string|nullable',
        ]);
        $data = RmBranch::create([
            'name' => $req->name,
            'address' => $req->address,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function delete($id)
    {
        $data = RmBranch::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
