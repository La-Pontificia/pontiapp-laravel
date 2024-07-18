<?php

namespace App\Http\Controllers;

use App\Models\UserRole;

class UserRoleController extends Controller
{

    public function index()
    {
        $roles = UserRole::orderBy('created_at', 'asc')->get();
        return view('modules.users.user-roles.+page', compact('roles'));
    }

    public function create()
    {
        return view('modules.users.user-roles.create.+page');
    }

    public function slug($id)
    {
        $role = UserRole::find($id);
        return view('modules.users.user-roles.slug.+page', compact('role'));
    }
}
