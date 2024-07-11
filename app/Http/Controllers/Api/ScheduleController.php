<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    public function add(Request $request)
    {
        $request->validate([
            'id_user' => ['required', 'uuid'],

            'start_date' => 'required',
            'end_date' => 'required',

            'from' => 'required',
            'to' => 'required',

            'title' => 'max:255',
            'days' => ['required', 'array'],
        ]);

        $id_user = $request->id_user;

        $startDate =  Carbon::parse($request->start_date);
        $endDate =  Carbon::parse($request->end_date);

        $from = $request->from;
        $to = $request->to;

        $title = $request->title;
        $days = $request->days;

        $dayColors = $this->generateDayColors();


        $schedules = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dayOfWeek = $currentDate->dayOfWeek + 1;
            if (in_array($dayOfWeek, $days)) {
                $fromDateTime = $currentDate->copy()->setTimeFromTimeString($from);
                $toDateTime = $currentDate->copy()->setTimeFromTimeString($to);

                $schedules[] = [
                    'from' => $fromDateTime->format('Y-m-d H:i:s'),
                    'to' => $toDateTime->format('Y-m-d H:i:s'),
                    'color' => $dayColors[$dayOfWeek],
                ];
            }
            $currentDate->addDay();
        }
        $groupID = uniqid();

        $schedulesCreated = [];

        foreach ($schedules as $schedule) {
            $schedule = Schedule::create([
                'id_user' => $id_user,
                'group' => $groupID,
                'from' => $schedule['from'],
                'to' => $schedule['to'],
                'title' => $title ?? 'Horario laboral',
                'background' => $schedule['color'],
                'created_by' => auth()->user()->id
            ]);

            $schedulesCreated[] = $schedule;
        }


        return response()->json($schedulesCreated, 200);
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

    public function by_user($id_user)
    {
        $schedules = Schedule::where('id_user', $id_user)->get();
        return response()->json($schedules, 200);
    }
}
