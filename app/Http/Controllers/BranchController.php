<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $req)
    {
        $match = Branch::orderBy('created_at', 'asc');
        $query = $req->get('query');
        if ($query) {
            $match->where('name', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%')
                ->get();
        }

        $branches = $match->paginate();

        return view('modules.settings.branches.+page', compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * $branches->perPage());
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $branch = new Branch();
        $branch->name = $req->name;
        $branch->address = $req->address;
        $branch->created_by = Auth::id();
        $branch->save();

        $this->auditService->registerAudit('Sede creado', 'Se ha creado una sede', 'maintenances', 'create', $req);

        return response()->json('Sede creado correctamente.', 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $branch = Branch::find($id);
        $branch->name = $req->name;
        $branch->address = $req->address;
        $branch->updated_by = Auth::id();
        $branch->save();

        $this->auditService->registerAudit('Sede actualizado', 'Se ha actualizado una sede', 'maintenances', 'update', $req);

        return response()->json('Sede actualizado correctamente.', 200);
    }

    public function delete($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        $this->auditService->registerAudit('Sede eliminado', 'Se ha eliminado una sede', 'maintenances', 'delete', $branch);

        return response()->json('Sede eliminado correctamente.', 204);
    }
}
