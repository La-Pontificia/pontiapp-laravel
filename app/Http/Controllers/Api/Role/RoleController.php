<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function all(Request $req)
    {
        $match = Role::orderBy('created_at', 'desc');
        $job = $req->query('job');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%");
        if ($job) $match->where('jobId', $job);
        if (in_array('job', $relationship)) $match->with('job');
        if (in_array('department', $relationship)) $match->with('department');


        $roles = $paginate === 'true' ? $match->paginate() : $match->get();

        if (in_array('usersCount', $relationship)) {
            $roles->map(function ($role) {
                $role->usersCount = $role->usersCount();
                return $role;
            });
        }

        return response()->json($roles);
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'codePrefix' => 'required|string',
            'jobId' => 'required|string',
            'departmentId' => 'required|string',
        ]);

        $role = new Role();
        $role->name = $req->name;
        $role->jobId = $req->jobId;
        $role->codePrefix = $req->codePrefix;
        $role->departmentId = $req->departmentId;
        $role->save();

        return response()->json($role);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'codePrefix' => 'required|string',
            'jobId' => 'required|string',
            'departmentId' => 'required|string',
        ]);

        $role = Role::find($id);
        $role->name = $req->name;
        $role->jobId = $req->jobId;
        $role->codePrefix = $req->codePrefix;
        $role->departmentId = $req->departmentId;
        $role->save();

        return response()->json($role);
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role->users()->count() > 0) {
            return response()->json('Hay usuarios asociados a este cargo, por favor transfiera y vuelve a internarlo.', 400);
        }
        $role->delete();

        return response()->json(['message' => 'Role deleted']);
    }

    public function transfer(Request $req, $id)
    {

        $req->validate([
            'roleId' => 'required|string',
        ]);

        User::where('roleId', $id)->update(['roleId' => $req->roleId]);

        return response()->json('Users transferred');
    }
}
