<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GroupSchedule;
use App\Models\Schedule;
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
        $schedules = Schedule::where('id_user', $id_user)->get();
        return response()->json($schedules, 200);
    }

    public function add(Request $request, $group_id)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',

            'from' => 'required',
            'to' => 'required',

            'title' => 'max:255',
        ]);


        $days = array_map('intval', $request->input('days.*'));

        $startDate =  Carbon::parse($request->start_date);
        $endDate =  Carbon::parse($request->end_date);

        $currentDate = $startDate->copy();
        $fromDateTime = $currentDate->copy()->setTimeFromTimeString($request->from);
        $toDateTime = $currentDate->copy()->setTimeFromTimeString($request->to);


        $group = GroupSchedule::find($group_id);

        $title = $request->title;

        // $from = $request->from;
        // $to = $request->to;
        // $dayColors = $this->generateDayColors();

        if (!$group)  return response()->json('Group not found', 404);

        // add schedule
        $schedule = Schedule::create([
            'group_id' => $group->id,

            'from' => $fromDateTime,
            'to' => $toDateTime,

            'title' => $title ?? 'Horario laboral',
            'days' => json_encode($days),

            'start_date' =>  $startDate,
            'end_date' =>  $endDate,

            'background' => $this->generateRandomColor(),
            'created_by' => auth()->user()->id
        ]);

        // $schedules = [];
        // $currentDate = $startDate->copy();

        // while ($currentDate <= $endDate) {
        //     $dayOfWeek = $currentDate->dayOfWeek + 1;
        //     if (in_array($dayOfWeek, $days)) {
        //         $fromDateTime = $currentDate->copy()->setTimeFromTimeString($from);
        //         $toDateTime = $currentDate->copy()->setTimeFromTimeString($to);

        //         $schedules[] = [
        //             'from' => $fromDateTime->format('Y-m-d H:i:s'),
        //             'to' => $toDateTime->format('Y-m-d H:i:s'),
        //             'color' => $dayColors[$dayOfWeek],
        //         ];
        //     }
        //     $currentDate->addDay();
        // }
        // $groupID = uniqid();

        // $schedulesCreated = [];

        // foreach ($schedules as $schedule) {
        //     $schedule = Schedule::create([
        //         'id_user' => $id_user,
        //         'group' => $groupID,
        //         'from' => $schedule['from'],
        //         'to' => $schedule['to'],
        //         'title' => $title ?? 'Horario laboral',
        //         'background' => $schedule['color'],
        //         'created_by' => auth()->user()->id
        //     ]);

        //     $schedulesCreated[] = $schedule;
        // }


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


        $schedule->from = $fromDateTime;
        $schedule->to = $toDateTime;
        $schedule->title = $request->title;
        $schedule->days = json_encode($days);
        $schedule->start_date = $startDate;
        $schedule->end_date = $endDate;
        $schedule->updated_by = auth()->user()->id;
        $schedule->save();

        return response()->json($schedule, 200);
    }


    private function generateDayColors()
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

        $dayColors = [];
        for ($i = 1; $i <= 7; $i++) {
            $dayColors[$i] = $colors[array_rand($colors)];
        }

        return $dayColors;
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

        return $colors[array_rand($colors)];
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
        $schedule->save();
        return response()->json('Schedule archived successfully');
    }
}
