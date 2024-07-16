<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Branch;
use App\Models\Domain;
use App\Models\GroupSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
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

    // public function slug_attendance(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if (!$user) return view('pages.500', ['error' => 'User not found']);


    //     $startDate = '2024-07-12';
    //     $endDate = '2024-07-12';

    //     $assistances = Attendance::where('emp_code', $user->dni)
    //         ->whereRaw("CAST(punch_time AS DATE) >= '$startDate'")
    //         ->whereRaw("CAST(punch_time AS DATE) <= '$endDate'")
    //         ->orderBy('punch_time', 'asc')
    //         ->get();

    //     $schedulesMatched = $user->groupSchedule->schedules;
    //     $customSchedule = Schedule::where('user_id', $user->id)->get();
    //     $allSchedules = $schedulesMatched->merge($customSchedule);

    //     $schedulesGenerated = [];

    //     foreach ($allSchedules as $schedule) {
    //         $days = json_decode($schedule->days);
    //         $startDate = Carbon::parse($schedule->start_date);
    //         $endDate = Carbon::parse($schedule->end_date);
    //         for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
    //             $dayOfWeek = $date->dayOfWeek + 1;
    //             if ($dayOfWeek == 8) $dayOfWeek = 1;
    //             if (in_array((string)$dayOfWeek, $days)) {
    //                 $schedulesGenerated[] = [
    //                     'title' => $schedule->title,
    //                     'from' => Carbon::parse($schedule->from)->setDateFrom($date)->format('Y-m-d H:i:s'),
    //                     'to' => Carbon::parse($schedule->to)->setDateFrom($date)->format('Y-m-d H:i:s'),
    //                 ];
    //             }
    //         }
    //     }

    //     $schedules = $schedulesGenerated;

    //     return view('modules.users.slug.attendance.+page', compact('user', 'schedules', 'assistances'));
    // }

    public function slug_attendance(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $startDate = '2024-07-01';
        $endDate = '2024-07-31';

        $assistances = Attendance::where('emp_code', $user->dni)
            ->whereRaw("CAST(punch_time AS DATE) >= '$startDate'")
            ->whereRaw("CAST(punch_time AS DATE) <= '$endDate'")
            ->orderBy('punch_time', 'asc')
            ->get();

        $schedulesMatched = $user->groupSchedule->schedules;
        $customSchedule = Schedule::where('user_id', $user->id)->get();
        $allSchedules = $schedulesMatched->merge($customSchedule);

        $schedulesGenerated = [];

        foreach ($allSchedules as $schedule) {
            $days = json_decode($schedule->days);
            $scheduleStartDate = Carbon::parse($schedule->start_date);
            $scheduleEndDate = Carbon::parse($schedule->end_date);

            for ($date = $scheduleStartDate; $date->lte($scheduleEndDate); $date->addDay()) {
                $dayOfWeek = $date->dayOfWeek + 1;
                if ($dayOfWeek == 8) $dayOfWeek = 1;

                if (in_array((string)$dayOfWeek, $days)) {
                    $scheduleFrom = Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day);
                    $scheduleTo = Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day);

                    $i_enter = null;
                    $he_left = null;
                    $time_worked = null;
                    $time_delayed = null;

                    $entry = $assistances->first(function ($assistance) use ($scheduleFrom) {
                        $assistanceTime = Carbon::parse($assistance->punch_time);
                        return $assistanceTime->between($scheduleFrom->copy()->subMinutes(60), $scheduleFrom->copy()->addMinutes(60));
                    });

                    if ($entry) {
                        $i_enter = Carbon::parse($entry->punch_time);
                    }

                    $exit = $assistances->first(function ($assistance) use ($scheduleTo) {
                        $assistanceTime = Carbon::parse($assistance->punch_time);
                        return $assistanceTime->between($scheduleTo->copy()->subMinutes(60), $scheduleTo->copy()->addMinutes(60));
                    });

                    if ($exit) {
                        $he_left = Carbon::parse($exit->punch_time);
                    }

                    if ($i_enter && $he_left) {
                        $time_worked = $he_left->diffInMinutes($i_enter);
                        //                 // $time_delayed = max(0, $i_enter->diffInMinutes($scheduleFrom)); // Tiempo que debería haber llegado tarde
                    }

                    $schedulesGenerated[] = [
                        'title' => $schedule->title,
                        'dept_name' => $entry ? $entry->dept_name : null,
                        'from' => $scheduleFrom->format('Y-m-d H:i:s'),
                        'to' => $scheduleTo->format('Y-m-d H:i:s'),
                        'i_enter' => $i_enter ? $i_enter->format('Y-m-d H:i:s') : null,
                        'he_left' => $he_left ? $he_left->format('Y-m-d H:i:s') : null,
                        'time_worked' => $time_worked,
                        'time_delayed' => $time_delayed,
                    ];
                }
            }
        }

        $schedules = collect($schedulesGenerated)
            ->sortBy('from')
            ->filter(function ($schedule) use ($startDate, $endDate) {
                $from = Carbon::parse($schedule['from']);
                $to = Carbon::parse($schedule['to']);
                $filterStart = Carbon::parse($startDate)->startOfDay();
                $filterEnd = Carbon::parse($endDate)->endOfDay();
                return $from->between($filterStart, $filterEnd) || $to->between($filterStart, $filterEnd);
            })
            ->values()
            ->all();

        return view('modules.users.slug.attendance.+page', compact('user', 'schedules', 'assistances'));
    }



    // $from = $request->get('from') ? Carbon::parse($request->get('from'))->startOfDay() : Carbon::now()->subMonth()->startOfDay();
    // $to = $request->get('to') ? Carbon::parse($request->get('to'))->endOfDay() : Carbon::now()->endOfDay();



    // schedules
    public function schedules()
    {
        return view('modules.users.schedules.+page');
    }
}
