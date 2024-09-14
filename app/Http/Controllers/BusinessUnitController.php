<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    public function index()
    {
        $businesses = BusinessUnit::paginate();
        return view('modules.settings.business-units.+page', [
            'businesses' => $businesses
        ])
            ->with('i', (request()->input('page', 1) - 1) * $businesses->perPage());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'acronym' => 'string|nullable',
            'domain' => 'required',
        ]);

        $services =  $request->input('services', []);

        BusinessUnit::create([
            'name' => $request->name,
            'domain' => $request->domain,
            'acronym' => $request->acronym,
            'services' => $services,
            'created_by' => auth()->id(),
        ]);

        return response()->json('Unidad de negocio creado.', 200);
    }

    public function updated(Request $request, $id)
    {
        $businessUnit = BusinessUnit::find($id);

        if (!$businessUnit) {
            return response()->json('Business unit not found', 404);
        }

        $request->validate([
            'name' => 'required',
            'acronym' => 'string|nullable',
            'domain' => 'required',
        ]);

        $services =  $request->input('services', []);

        $businessUnit->update([
            'name' => $request->name,
            'acronym' => $request->acronym,
            'domain' => $request->domain,
            'services' => $services,
            'updated_by' => auth()->id(),
        ]);

        return response()->json('Unidad de negocio actualizada.', 200);
    }

    public function delete($id)
    {
        $businessUnit = BusinessUnit::find($id);

        if (!$businessUnit) {
            return response()->json('Business unit not found', 404);
        }

        $businessUnit->delete();

        return response()->json('Empresa eliminado', 200);
    }
}
