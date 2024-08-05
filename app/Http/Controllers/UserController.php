<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Domain;
use App\Models\Email;
use App\Models\GroupSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

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
        $groupSchedules = $user->groupSchedule->schedules;
        $userSchedules = Schedule::where('user_id', $user->id)->get();
        $allSchedules = $groupSchedules->merge($userSchedules);
        $schedulesGenerated = [];

        $currentStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $startDate = $request->get('start_date', $currentStartDate);
        $endDate = $request->get('end_date', $currentEndDate);

        foreach ($allSchedules as $schedule) {
            $start = Carbon::parse($schedule->start_date);
            $end = Carbon::parse($schedule->end_date);
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (in_array($date->dayOfWeekIso, json_decode($schedule->days))) {
                    $schedulesGenerated[] = [
                        'id' => $schedule->id,
                        'group_id' => $schedule->group_id,
                        'user_id' => $schedule->user_id,
                        'title' => $schedule->title,
                        'date' => $date->format('Y-m-d'),
                        'from' => Carbon::parse($schedule->from)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'from_start' => Carbon::parse($schedule->from_start)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'from_end' => Carbon::parse($schedule->from_end)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'to' => Carbon::parse($schedule->to)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'to_start' => Carbon::parse($schedule->to_start)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'to_end' => Carbon::parse($schedule->to_end)->setDateFrom($date)->format('Y-m-d H:i:s'),
                        'created_at' => $schedule->created_at,
                        'updated_at' => $schedule->updated_at,
                    ];
                }
            }
        }
        $schedules = $schedulesGenerated;
        usort($schedules, function ($a, $b) {
            return strcmp($a['date'], $b['date']);
        });

        $schedules = array_filter($schedules, function ($schedule) use ($startDate, $endDate) {
            $date = Carbon::parse($schedule['date']);
            return $date->between(Carbon::parse($startDate), Carbon::parse($endDate));
        });

        $terminals = [
            'pl-alameda',
            'pl-andahuaylas',
            'pl-casuarina',
            'pl-cybernet',
            'pl-jazmines',
            'rh-alameda',
            'rh-andahuaylas',
            'rh-casuarina',
            'rh-jazmines',
        ];

        //--------------------------- attendances ---------------------------
        $queryTerminals = $request->get('terminals') ? explode(',', $request->get('terminals')) : ['pl-alameda'];
        $queryUsersIds = $request->get('users') ? explode(',', $request->get('users')) : [$user->dni];
        $finalTerminals = array_filter($terminals, function ($terminal) use ($queryTerminals) {
            return in_array($terminal, $queryTerminals);
        });

        $connections = $finalTerminals;


        $assistances = collect();

        foreach ($connections as $connection) {
            $match = (new Attendance())
                ->setConnection($connection)
                ->where('emp_code', $user->dni)
                ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
                ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
                ->orderBy('punch_time', 'desc')
                ->get();
            $assistances = $assistances->merge($match);
        }


        $schedules = array_filter($schedules, function ($schedule) use ($startDate, $endDate) {
            $date = Carbon::parse($schedule['date']);
            return $date->between(Carbon::parse($startDate), Carbon::parse($endDate));
        });

        foreach ($schedules as &$schedule) {
            $date = Carbon::parse($schedule['date']);
            $from = Carbon::parse($schedule['from']);
            $fromStart = Carbon::parse($schedule['from_start']);
            $fromEnd = Carbon::parse($schedule['from_end']);
            $to = Carbon::parse($schedule['to']);
            $toStart = Carbon::parse($schedule['to_start']);
            $toEnd = Carbon::parse($schedule['to_end']);

            $entry = $assistances->first(function ($assistance) use ($fromStart, $fromEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($fromStart, $fromEnd);
            });

            $exit = $assistances->first(function ($assistance) use ($toStart, $toEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($toStart, $toEnd);
            });


            $schedule['marked_in'] = $entry ? Carbon::parse($entry->punch_time)->format('H:i:s') : null;
            $schedule['marked_out'] = $exit ? Carbon::parse($exit->punch_time)->format('H:i:s') : null;
            $schedule['terminal'] = $entry ? $entry->terminal_alias : ($exit ? $exit->terminal_alias : null);

            // Observations & Owes Time
            $observations = [];
            $owesTime = null;

            if (!$entry) {
                $observations[] = 'No marcó entrada';
            } elseif (Carbon::parse($entry->punch_time)->gt($from)) {
                $observations[] = 'Tardanza';
            }

            if (!$exit) {
                $observations[] = 'No marcó salida';
            } elseif (Carbon::parse($exit->punch_time)->lt($to)) {
                $observations[] = 'Salida Temprana';
            }

            if ($entry && $exit) {
                if (Carbon::parse($entry->punch_time)->lte($from) && Carbon::parse($exit->punch_time)->gte($to)) {
                    $observations[] = null;
                    $owesTime = 0;
                } else {
                    if (Carbon::parse($entry->punch_time)->gt($from)) {
                        $owesTime = Carbon::parse($entry->punch_time)->diffInMinutes($from);
                    } else $owesTime = 0;
                    if (Carbon::parse($exit->punch_time)->lt($to)) {
                        $owesTime += $to->diffInMinutes(Carbon::parse($exit->punch_time));
                    }
                }
            }
            $schedule['observations'] = implode(', ', $observations);
            $schedule['owes_time'] = is_numeric($owesTime) ? gmdate('H:i:s', $owesTime * 60) : null;
        }
        return view('modules.users.slug.assists.+page', compact('user', 'schedules', 'assistances'));
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
