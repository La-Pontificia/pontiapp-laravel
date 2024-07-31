<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GroupSchedule;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{



    public function group(Request $request)
    {
        $request->validate([
            'name' => ['max:255', 'required', 'string'],
        ]);

        $group = GroupSchedule::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);
        return response()->json($group, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['max:255', 'required', 'string'],
        ]);

        $group = GroupSchedule::find($id);
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->name = $request->name;
        $group->save();

        return response()->json($group, 200);
    }

    public function by_user($id_user)
    {
        $user = User::find($id_user);

        $group = $user->groupSchedule->schedules->filter(function ($schedule) {
            return !$schedule->archived;
        });

        $userSchedules = Schedule::where('user_id', $user->id)->where('archived', false)->get();

        $schedules = $group->merge($userSchedules);

        return response()->json($schedules, 200);
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',

            'from' => 'required',
            'to' => 'required',

            'title' => 'max:255',
        ]);

        $user_id =  $request->user_id;


        $days = array_map('intval', $request->input('days.*'));

        $startDate =  Carbon::parse($request->start_date);
        $endDate =  Carbon::parse($request->end_date);

        $currentDate = $startDate->copy();

        $fromDateTime = $currentDate->copy()->setTimeFromTimeString($request->from);
        $toDateTime = $currentDate->copy()->setTimeFromTimeString($request->to);

        $fromStart = $currentDate->copy()->setTimeFromTimeString($request->from_start);
        $fromEnd = $currentDate->copy()->setTimeFromTimeString($request->from_end);

        $toStart = $currentDate->copy()->setTimeFromTimeString($request->to_start);
        $toEnd = $currentDate->copy()->setTimeFromTimeString($request->to_end);

        $group = GroupSchedule::find($id);

        $title = $request->title;

        if (!$group && !$user_id)  return response()->json('Group not found', 404);

        $schedule = Schedule::create([
            'group_id' => $user_id ? null : $group->id,
            'user_id' => $user_id ?? null,

            'from' => $fromDateTime,
            'to' => $toDateTime,

            'title' => $title ?? 'Horario laboral',
            'days' => json_encode($days),

            'start_date' =>  $startDate,
            'end_date' =>  $endDate,

            'from_start' => $fromStart,
            'from_end' => $fromEnd,

            'to_start' => $toStart,
            'to_end' => $toEnd,

            'background' => $this->generateRandomColor(),
            'created_by' => auth()->user()->id
        ]);

        return response()->json($schedule, 200);
    }

    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',

            'from' => 'required',
            'to' => 'required',

            'title' => 'max:255',
        ]);

        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json('Schedule not found', 404);
        }

        $days = array_map('intval', $request->input('days.*'));

        $startDate =  Carbon::parse($request->start_date);
        $endDate =  Carbon::parse($request->end_date);

        $currentDate = $startDate->copy();

        $fromDateTime = $currentDate->copy()->setTimeFromTimeString($request->from);
        $toDateTime = $currentDate->copy()->setTimeFromTimeString($request->to);

        $fromStart = $currentDate->copy()->setTimeFromTimeString($request->from_start);
        $fromEnd = $currentDate->copy()->setTimeFromTimeString($request->from_end);

        $toStart = $currentDate->copy()->setTimeFromTimeString($request->to_start);
        $toEnd = $currentDate->copy()->setTimeFromTimeString($request->to_end);


        $schedule->from = $fromDateTime;
        $schedule->to = $toDateTime;
        $schedule->title = $request->title;
        $schedule->days = json_encode($days);
        $schedule->start_date = $startDate;
        $schedule->end_date = $endDate;
        $schedule->from_start = $fromStart;
        $schedule->from_end = $fromEnd;
        $schedule->to_start = $toStart;
        $schedule->to_end = $toEnd;
        $schedule->updated_by = auth()->user()->id;
        $schedule->save();

        return response()->json($schedule, 200);
    }

    private function generateRandomColor()
    {
        $colors = [
            '#475569',
            '#4b5563',
            '#52525b',
            '#525252',
            '#dc2626',
            '#ea580c',
            '#d97706',
            '#ca8a04',
            '#65a30d',
            '#16a34a',
            '#059669',
            '#0d9488',
            '#0891b2',
            '#0284c7',
            '#2563eb',
            '#7c3aed',
            '#9333ea',
            '#c026d3',
            '#db2777',
            '#e11d48'
        ];

        $hour = (int)date('G');

        $index = $hour % count($colors);

        return $colors[$index];
    }

    public function schedules($id)
    {
        $group_schedule = GroupSchedule::find($id);
        $schedules = $group_schedule->schedules()->orderBy('from', 'asc')->get();

        return response()->json($schedules, 200);
    }

    public function remove($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json('Schedule not found', 404);
        }

        $schedule->delete();
        return response()->json('Schedule removed');
    }


    public function archive($id)
    {
        $schedule = Schedule::find($id);
        $schedule->archived = true;
        $schedule->end_date = Carbon::now();
        $schedule->save();
        return response()->json('Schedule archived successfully');
    }
}
