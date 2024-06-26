<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $match = Branch::orderBy('created_at', 'asc');
        $q = $request->get('q');
        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%')
                ->get();
        }
        $branches = $match->paginate();
        return view('pages.branches.index', compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * $branches->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $department = new Branch();
        $department->name = $request->name;
        $department->address = $request->address;
        $department->created_by = auth()->user()->id;
        $department->save();

        return response()->json($department, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $department = Branch::find($id);
        $department->name = $request->name;
        $department->address = $request->address;
        $department->updated_by = auth()->user()->id;
        $department->save();

        return response()->json($department, 200);
    }
}
