<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $match = User::orderBy('created_at', 'asc');
        $query = $request->get('q');
        $job_position = $request->get('job_position');
        $job_positions = JobPosition::all();
        $role = $request->get('role');
        $users = [];

        // filters
        if ($job_position) {
            $match->whereHas('role_position', function ($q) use ($job_position) {
                $q->where('id_job_position', $job_position);
            });
        }

        if ($role) {
            $match->where('id_role', $role);
        }

        if ($query) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->get();
        }

        $jobPostions = JobPosition::all();
        $roles = Role::all();

        $users = $match->paginate();

        return view('modules.users.+page', compact('users', 'job_positions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    // ROLES

    public function roles()
    {
        return view('modules.users.roles.+page');
    }

    public function createRole()
    {
        return view('modules.users.roles.create.+page');
    }


    public function create()
    {

        $job_positions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $branches = Branch::all();
        return view('modules.users.create.+page', compact('job_positions', 'roles', 'branches', 'user_roles'));
    }

    public function edit($id)
    {

        $job_positions = JobPosition::all();
        $roles = Role::all();
        $branches = Branch::all();
        $user = User::find($id);

        return view('pages.users.edit', compact('job_positions', 'roles', 'branches', 'user'));
    }

    // slugs
    public function slug($id)
    {
        $user = User::find($id);
        $job_positions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $branches = Branch::all();
        return view('modules.users.slug.+page', compact('user', 'job_positions', 'roles', 'user_roles', 'branches'));
    }
}
