<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {

        $group_schedules = GroupSchedule::orderBy('created_at', 'asc')->get();
        return view('modules.users.schedules.+page', compact('group_schedules'));
    }

    public function create()
    {
        return view('modules.users.schedules.create.+page');
    }

    public function schedule($id)
    {
        $formSchedule = new Schedule();
        $group_schedule = GroupSchedule::find($id);
        $schedules = $group_schedule->schedules()->orderBy('from', 'asc')->get();
        return view('modules.users.schedules.slug.+page', compact('group_schedule', 'schedules', 'formSchedule'));
    }
}
