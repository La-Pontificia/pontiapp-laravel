<?php

namespace App\Http\Controllers;

use App\Models\GroupSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {

        $group_schedules = GroupSchedule::orderBy('created_at', 'asc')->get();
        return view('modules.schedules.+page', compact('group_schedules'));
    }

    public function external(Request $request)
    {
        $group_schedules = GroupSchedule::orderBy('created_at', 'asc')->get();
        return view('modules.schedules.external.+page', compact('group_schedules'));
    }

    public function create()
    {
        return view('modules.users.schedules.create.+page');
    }

    public function slug($id)
    {
        $group_schedule = GroupSchedule::find($id);
        $schedules = $group_schedule->schedules()->orderBy('from', 'asc')->get();

        return view('modules.schedules.slug.+page', compact('group_schedule', 'schedules'));
    }
}
