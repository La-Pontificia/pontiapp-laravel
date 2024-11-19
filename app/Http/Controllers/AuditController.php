<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\services\AuditService;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $req)
    {

        $match = Audit::orderBy('created_at', 'desc')->limit(20);

        $query = $req->get('query');
        $action = $req->get('action');
        $module = $req->get('module');

        if ($query) {
            $match->whereHas('user', function ($q) use ($query) {
                $q->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('dni', 'like', '%' . $query . '%');
            })->orWhere('description', 'like', '%' . $query . '%')
                ->orWhere('module', 'like', '%' . $query . '%')
                ->orWhere('action', 'like', '%' . $query . '%')
                ->orWhere('title', 'like', '%' . $query . '%');
        }

        if ($action) {
            $match->where('action', $action);
        }

        if ($module) {
            $match->where('module', $module);
        }

        $records = $match->paginate();

        return view('modules.audit.+page', compact('records'))->with('i', (request()->input('page', 1) - 1) * $records->perPage());
    }

    public function delete($id)
    {
        $audit = Audit::find($id);
        $audit->delete();

        $this->auditService->registerAudit('Registro eliminado', 'Se ha eliminado un registro', 'audits', 'delete', request());

        return response()->json('Registro eliminado correctamente');
    }
}
