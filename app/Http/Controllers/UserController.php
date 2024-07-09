<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('pages.users.index', compact('users', 'job_positions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $job_positions = JobPosition::all();
        $roles = Role::all();
        $branches = Branch::all();
        return view('pages.users.create', compact('job_positions', 'roles', 'branches'));
    }

    public function edit($id)
    {

        $job_positions = JobPosition::all();
        $roles = Role::all();
        $branches = Branch::all();
        $user = User::find($id);

        return view('pages.users.edit', compact('job_positions', 'roles', 'branches', 'user'));
    }
}
