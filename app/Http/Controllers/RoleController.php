<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosition;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    // roles
    public function index(Request $request)
    {
        $match = Role::orderBy('created_at', 'asc');
        $q = $request->get('q');
        $id_job_position = $request->get('job-position');
        $id_department = $request->get('department');

        $departments = Department::orderBy('name', 'asc')->get();
        $jobPositions = JobPosition::orderBy('name', 'asc')->get();

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%');
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id_job_position' => ['required', 'uuid'],
            'id_department' => ['required', 'uuid'],
        ]);

        $alreadyExistCode = Role::where('code', $request->code)->first();
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
        $new->name = $request->name;
        $new->id_job_position = $request->id_job_position;
        $new->id_department = $request->id_department;
        $new->created_by = auth()->user()->id;
        $new->save();

        return response()->json($new, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'id_job_position' => ['required', 'uuid'],
            'id_department' => ['required', 'uuid'],
        ]);

        $alreadyExistCode = Role::where('code', $request->code)->first();

        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $update = Role::find($id);
        $update->code = $request->code;
        $update->name = $request->name;
        $update->id_job_position = $request->id_job_position;
        $update->id_department = $request->id_department;
        $update->updated_by = auth()->user()->id;
        $update->save();

        return response()->json($update, 200);
    }
}
