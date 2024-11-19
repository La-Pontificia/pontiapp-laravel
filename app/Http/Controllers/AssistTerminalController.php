<?php

namespace App\Http\Controllers;

use App\Models\AssistTerminal;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistTerminalController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        $terminals = AssistTerminal::all();
        return view('modules.assists.terminals.+page', [
            'terminals' => $terminals
        ]);
    }

    public function store(Request $req)
    {
        $req->validate(AssistTerminal::$rules);
        $data = $req->all();

        $exists = AssistTerminal::where('database_name', $data['database_name'])->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Database name already exists');
        }

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        AssistTerminal::create($data);


        $this->auditService->registerAudit('Terminal registrada', 'Se ha registrado una terminal', 'assists', 'create', $req);

        return response()->json('Terminal registrada.');
    }

    public function update(Request $req, $id)
    {
        $terminal = AssistTerminal::find($id);

        if (!$terminal) {
            return response()->json('Terminal not found', 404);
        }

        $req->validate(AssistTerminal::$rules);
        $data = $req->all();

        $exists = AssistTerminal::where('database_name', $data['database_name'])->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Database name already exists');
        }

        $data['updated_by'] = Auth::id();
        $terminal->update($data);

        $this->auditService->registerAudit('Terminal actualizada', 'Se ha actualizado una terminal', 'assists', 'update', $req);

        return response()->json('Terminal actualizada.');
    }

    public function delete($id)
    {
        $terminal = AssistTerminal::find($id);

        if (!$terminal) {
            return response()->json('Terminal not found', 404);
        }

        $terminal->delete();

        $this->auditService->registerAudit('Terminal eliminada', 'Se ha eliminado una terminal', 'assists', 'delete', request());

        return response()->json('Terminal eliminada.');
    }
}
