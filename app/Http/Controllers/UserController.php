<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Domain;
use App\Models\GroupSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserRole;
use App\services\AssistsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $assistsService;

    public function __construct(AssistsService $assistsService)
    {
        $this->assistsService = $assistsService;
    }

    public function index(Request $request)
    {

        $match = User::orderBy('created_at', 'desc');
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

        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $group = $user->groupSchedule->schedules->filter(function ($schedule) {
            return !$schedule->archived;
        });
        $userSchedules = Schedule::where('user_id', $user->id)->where('archived', false)->get();

        $schedules = $group->merge($userSchedules);

        return view('modules.users.slug.schedules.+page', compact('user',  'schedules'));
    }



    public function slug_assists(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $terminals = $request->get('terminals') ? explode(',', $request->get('terminals')) : ['pl-alameda'];
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $schedules = $this->assistsService->assistsByUser($user->id, $terminals, $startDate, $endDate);
        return view('modules.users.slug.assists.+page', compact('user', 'schedules'));
    }

    // schedules
    public function schedules()
    {
        return view('modules.users.schedules.+page');
    }

    // emails
    public function emails(Request $request)
    {

        $match = User::orderBy('created_at', 'desc');
        $query = $request->get('q');
        $status = $request->get('status');

        if ($status) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%');
            // where('discharged', $status === 'actives' ? null : '!=', null);
        }

        $domains = Domain::all();
        $users = $match->paginate();

        return view('modules.users.emails.+page', [
            'domains' => $domains,
            'users' => $users
        ])
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    // domains 
    public function domains()
    {
        return view('modules.users.domains.+page');
    }

    // job positions 
    public function jobPositions(Request $request)
    {
        $match = JobPosition::orderBy('level', 'asc');
        $q = $request->get('q');
        $level = $request->get('level');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%')
                ->get();
        }

        if ($level) {
            $match->where('level', $level);
        }

        $jobPositions = $match->paginate();
        $lastJobPositions = JobPosition::orderBy('created_at', 'desc')->first();

        $newCode = 'P-001';
        if ($lastJobPositions) {
            $newCode = 'P-' . str_pad((int)explode('-', $lastJobPositions->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }
        return view('modules.users.job-positions.+page', compact('jobPositions', 'newCode'))
            ->with('i', (request()->input('page', 1) - 1) * $jobPositions->perPage());
    }

    // roles
    public function roles(Request $request)
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
        return view('modules.users.roles.+page', compact('roles', 'newCode', 'departments', 'jobPositions'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }
}
