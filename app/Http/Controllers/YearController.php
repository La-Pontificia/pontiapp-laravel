<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{

    public function index(Request $request)
    {
        $match = Year::orderBy('name', 'asc');
        $q = $request->get('q');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')->get();
        }

        $years = $match->paginate();

        return view('pages.years.index', compact('years'))
            ->with('i', (request()->input('page', 1) - 1) * $years->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $alreadyExistCode = Year::where('name', $request->name)->first();
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo nombre.', 500);
        }

        $year = new Year();
        $year->name = $request->name;
        $year->status = $request->status ? true : false;
        $year->created_by = auth()->user()->id;
        $year->save();

        return response()->json($year, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $alreadyExistCode = Year::where('name', $request->name)->first();
        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo nombre.', 500);
        }

        $year = Year::find($id);
        $year->name = $request->name;
        $year->status = $request->status ? true : false;
        $year->updated_by = auth()->user()->id;
        $year->save();

        return response()->json($year, 200);
    }
}
