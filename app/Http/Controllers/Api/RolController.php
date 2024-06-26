<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RolController extends Controller
{

    public function by_job_position($id)
    {
        $roles = Role::where('id_job_position', $id)->get();
        return response()->json($roles);
    }
}
