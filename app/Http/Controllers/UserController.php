<?php

namespace App\Http\Controllers;

use App\Models\AssistTerminal;
use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ContractType;
use App\Models\Department;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserRole;
use App\services\AssistsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $assistsService;

    public function __construct(AssistsService $assistsService)
    {
        $this->assistsService = $assistsService;
    }

    public function index(Request $req, $isExport = false, $onlyMatch = false)
    {

        $match = User::orderBy('created_at', 'desc');
        $query = $req->get('query');
        $job_position = $req->get('job_position');
        $status = $req->get('status');
        $role = $req->get('role');
        $department = $req->get('department');
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


        if ($isExport) {
            return $match->get();
        }

        if ($onlyMatch) {
            return $match;
        }

        $users = $match->paginate();

        return view('modules.users.+page', compact('users', 'job_positions', 'user_roles', 'departments'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $cuser = User::find(Auth::id());
        $user_roles = UserRole::where('level', '>=', $cuser->role->level)->orderBy('level', 'asc')->get();

        $job_positions = JobPosition::all();
        $contracts = ContractType::all();
        $roles = Role::all();
        $users = User::all();
        $branches = Branch::all();
        $terminals = AssistTerminal::all();
        $business_units = BusinessUnit::all();
        return view('modules.users.create.+page', compact('job_positions', 'roles', 'branches', 'contracts', 'user_roles', 'terminals', 'users', 'business_units'));
    }

    public function slug($id)
    {
        $user = User::find($id);
        $cuser = User::find(Auth::id());
        $user_roles = UserRole::where('level', '>=', $cuser->role->level)->orderBy('level', 'asc')->get();

        $schedules = Schedule::where('user_id', $user->id)->where('archived', false)->get();
        $contracts = ContractType::all();
        $job_positions = JobPosition::all();
        $roles = Role::all();
        $terminals = AssistTerminal::all();
        $business_units = BusinessUnit::all();

        $users = User::whereHas('role_position', function ($q) use ($user) {
            $q->whereHas('job_position', function ($qq) use ($user) {
                $qq->where('level', '<=', $user->role_position->job_position->level);
            });
        })->get();

        $branches = Branch::all();

        if (!$user) return view('+500', ['error' => 'User not found']);
        return view('modules.users.slug.+page', compact('user', 'user_roles', 'schedules', 'contracts', 'job_positions', 'roles', 'branches', 'terminals', 'users', 'business_units'));
    }

    public function slug_schedules($id)
    {
        $user = User::find($id);

        if (!$user) return view('+500', ['error' => 'User not found']);

        $schedules = Schedule::where('user_id', $user->id)->where('archived', false)->get();
        $terminals = AssistTerminal::all();
        return view('modules.users.slug.schedules.+page', compact('user', 'schedules', 'terminals'));
    }

    public function slug_organization($id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);

        return view('modules.users.slug.organization.+page', compact('user'));
    }
}
