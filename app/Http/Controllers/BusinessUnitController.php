<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    public function index()
    {
        $businessUnits = BusinessUnit::paginate();
        return view('modules.settings.business-units.+page', [
            'businessUnits' => $businessUnits
        ])
            ->with('i', (request()->input('page', 1) - 1) * $businessUnits->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'domain' => 'required',
        ]);

        $services =  $request->input('services', []);

        $businessUnit = BusinessUnit::create([
            'name' => $request->name,
            'domain' => $request->domain,
            'services' => $services,
            'created_by' => auth()->id(),
        ]);

        return response()->json($businessUnit, 200);
    }

    public function updated(Request $request, $id)
    {
        $businessUnit = BusinessUnit::find($id);

        if (!$businessUnit) {
            return response()->json('Business unit not found', 404);
        }

        $request->validate([
            'name' => 'required',
            'domain' => 'required',
        ]);

        $services =  $request->input('services', []);

        $businessUnit->update([
            'name' => $request->name,
            'domain' => $request->domain,
            'services' => $services,
            'updated_by' => auth()->id(),
        ]);

        return response()->json($businessUnit, 200);
    }
}
