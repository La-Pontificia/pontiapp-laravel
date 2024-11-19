<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{

    public function index()
    {
        $cuser = User::find(Auth::id());
        $roles = UserRole::where('level', '>=', $cuser->role->level)->orderBy('level', 'asc')->get();
        return view('modules.users.user-roles.+page', compact('roles'));
    }
}
