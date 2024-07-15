<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\Domain;
use App\Models\GroupSchedule;
use App\Models\User;
use App\Models\UserRole;
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

        return view('modules.users.+page', compact('users', 'job_positions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {

        $job_positions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $branches = Branch::all();
        $domains = Domain::all();
        $group_schedules = GroupSchedule::all();

        return view('modules.users.create.+page', compact('job_positions', 'roles', 'branches', 'user_roles', 'domains', 'group_schedules'));
    }

    // slugs
    public function slug($id)
    {
        $user = User::find($id);
        $job_positions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $branches = Branch::all();
        $domains = Domain::all();
        $group_schedules = GroupSchedule::all();


        if (!$user) return view('pages.500', ['error' => 'User not found']);

        return view('modules.users.slug.+page', compact('user', 'job_positions', 'roles', 'user_roles', 'branches', 'domains', 'group_schedules'));
    }

    public function slug_organization($id)
    {
        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        return view('modules.users.slug.organization.+page', compact('user'));
    }

    public function slug_schedules($id)
    {
        $user = User::find($id);

        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $group_schedules = GroupSchedule::all();

        $schedules = $user->groupSchedule->schedules;
        return view('modules.users.slug.schedules.+page', compact('user', 'group_schedules', 'schedules'));
    }

    public function slug_attendance($id)
    {
        $user = User::find($id);

        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $group_schedules = GroupSchedule::all();

        $schedules = $user->groupSchedule->schedules;
        return view('modules.users.slug.attendance.+page', compact('user', 'group_schedules', 'schedules'));
    }


    // schedules
    public function schedules()
    {
        return view('modules.users.schedules.+page');
    }
}
