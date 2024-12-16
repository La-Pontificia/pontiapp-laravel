<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function all(Request $req)
    {
        $match = Department::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%");
        if (in_array('roles', $relationship)) $match->with('roles');
        if (in_array('area', $relationship)) $match->with('area');

        $departments = $match->get();

        return response()->json($departments);
    }
    public function create(Request $req)
    {

        $req->validate([
            'codePrefix' => 'required|string',
            'name' => 'required|string',
            'areaId' => 'required|string',
        ]);

        $department = new Department();
        $department->codePrefix = $req->codePrefix;
        $department->name = $req->name;
        $department->areaId = $req->areaId;
        $department->createdBy = Auth::id();
        $department->save();

        return response()->json($department);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'codePrefix' => 'required|string',
            'name' => 'required|string',
            'areaId' => 'required|string',
        ]);

        $department = Department::find($id);
        $department->codePrefix = $req->codePrefix;
        $department->name = $req->name;
        $department->areaId = $req->areaId;
        $department->updatedBy = Auth::id();
        $department->save();

        return response()->json($department);
    }

    public function delete($id)
    {
        $department = Department::find($id);

        if ($department->roles()->count() > 0) {
            return response()->json('Hay cargos asociados a este departamento, por favor transfiera y vuelve a internarlo.', 400);
        }

        $department->delete();

        return response()->json(['message' => 'Department deleted']);
    }
}
