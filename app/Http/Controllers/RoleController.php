<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosition;
use App\Models\Role;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    // roles
    public function index(Request $req)
    {
        $match = Role::orderBy('created_at', 'asc');
        $query = $req->get('query');
        $id_job_position = $req->get('job-position');
        $id_department = $req->get('department');

        $departments = Department::orderBy('name', 'asc')->get();
        $jobPositions = JobPosition::orderBy('name', 'asc')->get();

        if ($query) {
            $match->where('name', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%');
        }

        if ($id_job_position) {
            $match->where('id_job_position', $id_job_position);
        }

        if ($id_department) {
            $match->where('id_department', $id_department);
        }

        $roles = $match->paginate();
        $last = Role::orderBy('code', 'desc')->first();

        $newCode = 'C-001';
        if ($last) {
            $newCode = 'C-' . str_pad((int)explode('-', $last->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }
        return view('modules.settings.roles.+page', compact('roles', 'newCode', 'departments', 'jobPositions'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'id_job_position' => ['required', 'uuid'],
            'id_department' => ['required', 'uuid'],
        ]);

        $alreadyExistCode = Role::where('code', $req->code)->first();
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $last = Role::orderBy('created_at', 'desc')->first();
        $code = 'C-001';
        if ($last) {
            $code = 'C-' . str_pad((int)explode('-', $last->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        $new = new Role();
        $new->code = $code;
        $new->name = $req->name;
        $new->id_job_position = $req->id_job_position;
        $new->id_department = $req->id_department;
        $new->created_by = Auth::id();
        $new->save();

        $this->auditService->registerAudit('Cargo creado', 'Se ha creado un cargo', 'maintenances', 'create', $req);

        return response()->json('Cargo registrado correctamente.', 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'code' => 'required',
            'id_job_position' => ['required', 'uuid'],
            'id_department' => ['required', 'uuid'],
        ]);

        $alreadyExistCode = Role::where('code', $req->code)->first();

        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $update = Role::find($id);
        $update->code = $req->code;
        $update->name = $req->name;
        $update->id_job_position = $req->id_job_position;
        $update->id_department = $req->id_department;
        $update->updated_by = Auth::id();
        $update->save();

        $this->auditService->registerAudit('Cargo actualizado', 'Se ha actualizado un cargo', 'maintenances', 'update', $req);

        return response()->json('Cargo actualizado correctamente.', 200);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();

        $this->auditService->registerAudit('Cargo eliminado', 'Se ha eliminado un cargo', 'maintenances', 'delete', request());
        return response()->json('Registro eliminado correctamente.', 200);
    }
}
