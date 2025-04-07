<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Models\Rm\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index(Request $req)
    {

        $match = Branch::orderBy('created_at', 'desc');
        $q = $req->query('q');

        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('address', 'like', "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(["name", "address", "id"]) + [
                'creator' => $item->creator ? $item->creator->only(["username", "displayName", "firstNames", "lastNames", "photoURL"]) : null
            ];
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
            'name' => 'required|string|unique:rm_branches',
            'address' => 'string|nullable',
        ]);
        $data = Branch::create([
            'name' => $req->name,
            'address' => $req->address,
            'creatorId' => Auth::id(),
        ]);
        return response()->json($data);
    }

    public function update(Request $req, $slug)
    {
        $req->validate([
            'name' => 'required|string|unique:rm_branches',
            'address' => 'string|nullable',
        ]);

        $found = Branch::find($slug);

        $found->update([
            'name' => $req->name,
            'address' => $req->address,
            'updaterId' => Auth::id(),
        ]);
        return response()->json('Ok');
    }

    public function delete($id)
    {
        $data = Branch::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
