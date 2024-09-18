<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;

class UserRoleController extends Controller
{

    public function index()
    {
        $cuser = User::find(auth()->user()->id);
        $roles = UserRole::where('level', '>=', $cuser->role->level)->orderBy('level', 'asc')->get();
        return view('modules.users.user-roles.+page', compact('roles'));
    }

    public function create()
    {
        return view('modules.users.user-roles.create.+page');
    }

    public function slug($id)
    {
        $cuser = User::find(auth()->user()->id);
        $roles = UserRole::where('level', '>=', $cuser->role->level)->orderBy('level', 'asc')->get();
        return view('modules.users.user-roles.slug.+page', compact('role'));
    }
}
