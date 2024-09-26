<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\services\AuditService;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }


    public function index(Request $request)
    {

        $query = $request->get('query');

        $match = BusinessUnit::orderBy('created_at', 'desc');

        if ($query) {
            $match->where('name', 'like', '%' . $query . '%')
                ->orWhere('acronym', 'like', '%' . $query . '%')
                ->get();
        }

        $businesses = $match->paginate();
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

        $this->auditService->registerAudit('Unidad de negocio creada', 'Se ha creado una unidad de negocio', 'maintenances', 'create', $request);

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

        $this->auditService->registerAudit('Unidad de negocio actualizada', 'Se ha actualizado una unidad de negocio', 'maintenances', 'update', $request);

        return response()->json('Unidad de negocio actualizada.', 200);
    }

    public function delete($id)
    {
        $businessUnit = BusinessUnit::find($id);

        if (!$businessUnit) {
            return response()->json('Business unit not found', 404);
        }

        $businessUnit->delete();

        $this->auditService->registerAudit('Unidad de negocio eliminada', 'Se ha eliminado una unidad de negocio', 'maintenances', 'delete', request());

        return response()->json('Empresa eliminado', 200);
    }
}
