<?php

namespace App\Http\Controllers;

use App\Models\AssistTerminal;
use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\Department;
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

    public function index(Request $request, $isExport = false, $onlyMatch = false)
    {

        $match = User::orderBy('created_at', 'desc');
        $query = $request->get('query');
        $job_position = $request->get('job_position');
        $status = $request->get('status');
        $role = $request->get('role');
        $department = $request->get('department');
        $job_positions = JobPosition::all();
        $user_roles = UserRole::all();
        $users = [];

        if ($status && $status == 'actives') {
            $match->where('status', true);
        }

        if ($status && $status == 'inactives') {
            $match->where('status', false);
        }

        if ($role) {
            $match->where('id_role_user', $role);
        }

        if ($job_position) {
            $match->whereHas('role_position', function ($q) use ($job_position) {
                $q->where('id_job_position', $job_position);
            });
        }

        if ($department) {
            $match->whereHas('role_position', function ($q) use ($department) {
                $q->whereHas('department', function ($q) use ($department) {
                    $q->where('id', $department);
                });
            });
        }

        if ($query) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%');
        }

        $jobPostions = JobPosition::all();
        $departments = Department::all();

        $users = $match->paginate();

        if ($isExport) {
            return $match->get();
        }

        if ($onlyMatch) {
            return $match;
        }

        return view('modules.users.+page', compact('users', 'job_positions', 'user_roles', 'departments'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function export(Request $request)
    {
        $users =  $this->index($request, true);

        foreach ($users as $user) {
            $user->role = $user->role;
            $user->area = $user->role_position->department->area;
            $user->department = $user->role_position->department;
            $user->role_position = $user->role_position;
            $user->job_position = $user->role_position->job_position;
            $user->branch = $user->branch;
            $user->supervisor = $user->supervisor;
            $user->schedule = $user->groupSchedule;
            $user->created_by = $user->createdBy;
            $user->updated_by = $user->updatedBy;
        }
        return response()->json($users);
    }

    public function exportEmailAccess(Request $request)
    {
        $users =  $this->index($request, true);

        foreach ($users as $user) {
        }
        return response()->json($users);
    }

    public function create()
    {

        $job_positions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $users = User::all();
        $branches = Branch::all();
        $group_schedules = GroupSchedule::all();
        $terminals = AssistTerminal::all();

        return view('modules.users.create.+page', compact('job_positions', 'roles', 'branches', 'user_roles', 'group_schedules', 'terminals', 'users'));
    }

    // slugs
    public function slug($id)
    {
        $user = User::find($id);
        $user_roles = UserRole::all();
        $group_schedules = GroupSchedule::all();
        $job_positions = JobPosition::all();
        $roles = Role::all();
        $terminals = AssistTerminal::all();
        $branches = Branch::all();
        if (!$user) return view('+500', ['error' => 'User not found']);
        return view('modules.users.slug.+page', compact('user', 'user_roles', 'group_schedules', 'job_positions', 'roles', 'branches', 'terminals'));
    }

    public function slug_details($id)
    {
        $user = User::find($id);
        $user_roles = UserRole::all();
        $group_schedules = GroupSchedule::all();
        if (!$user) return view('+500', ['error' => 'User not found']);

        return view('modules.users.slug.details.+page', compact('user', 'user_roles', 'group_schedules'));
    }

    public function slug_segurity_access($id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);
        return view('modules.users.slug.segurity-access.+page', compact('user'));
    }

    public function slug_organization($id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);

        return view('modules.users.slug.organization.+page', compact('user'));
    }

    public function slug_contract($id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);
        return view('modules.users.slug.contract.+page', compact('user'));
    }

    public function slug_schedules($id)
    {
        $user = User::find($id);

        if (!$user) return view('+500', ['error' => 'User not found']);

        $groupSchedules = $user->group_schedule_id ? $user->groupSchedule->schedules : collect();

        $userSchedules = Schedule::where('user_id', $user->id)->where('archived', false)->get();

        $schedules =  $groupSchedules->merge($userSchedules);

        return view('modules.users.slug.schedules.+page', compact('user',  'schedules'));
    }

    public function slug_assists(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);
        $terminals = AssistTerminal::all();

        $queryTerminal = null;

        if ($request->get('terminal')) {
            $queryTerminal = $request->get('terminal');
        } elseif ($user->defaultTerminal) {
            $queryTerminal = $user->defaultTerminal->database_name;
        } else {
            $queryTerminal = $terminals[0]->database_name;
        }

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));

        $schedules = $this->assistsService->assistsByUser($user->id, $queryTerminal, $startDate, $endDate);

        usort($schedules, function ($a, $b) {
            return strcmp($b['date'], $a['date']);
        });

        $terminals = AssistTerminal::all();
        return view('modules.users.slug.assists.+page', compact('user', 'schedules', 'terminals'));
    }

    // schedules
    public function schedules()
    {
        return view('modules.users.schedules.+page');
    }

    // emails
    public function emails_access(Request $request)
    {

        $res =  $this->index($request, false, true);
        $business_units = BusinessUnit::all();
        $users = $res->paginate();

        return view('modules.users.emails-access.+page', [
            'users' => $users,
            'business_units' => $business_units
        ])
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }
}
