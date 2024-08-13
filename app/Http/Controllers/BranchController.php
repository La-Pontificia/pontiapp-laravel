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

        return view('modules.settings.branches.+page', compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * $branches->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $branch = new Branch();
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->created_by = auth()->user()->id;
        $branch->save();

        return response()->json('Sede creado correctamente.', 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->updated_by = auth()->user()->id;
        $branch->save();

        return response()->json('Sede actualizado correctamente.', 200);
    }

    public function delete($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        return response()->json('Sede eliminado correctamente.', 204);
    }
}
