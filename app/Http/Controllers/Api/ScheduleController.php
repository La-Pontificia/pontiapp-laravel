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

    public function by_user($id_user)
    {
        $user = User::find($id_user);

        $groupSchedules = $user->group_schedule_id ? $user->groupSchedule->allSchedules : collect();

        $userSchedules = Schedule::where('user_id', $user->id)->get();

        $schedules = $groupSchedules->merge($userSchedules);

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


        $days = $request->input('days', []);

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

        Schedule::create([
            'group_id' => $user_id ? null : $group->id,
            'user_id' => $user_id ?? null,

            'from' => $fromDateTime,
            'to' => $toDateTime,

            'title' => $title ?? 'Horario laboral',
            'days' => $days,

            'start_date' =>  $startDate,
            'end_date' =>  $endDate,

            'from_start' => $fromStart,
            'from_end' => $fromEnd,

            'to_start' => $toStart,
            'to_end' => $toEnd,

            'background' => $request->background ?? $this->generateRandomColor(),
            'created_by' => auth()->user()->id
        ]);

        return response()->json('Horario registrado correctamente.', 200);
    }

    public function update(Request $request, $id)
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

        $days = $request->input('days', []);

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
        $schedule->days = $days;
        $schedule->start_date = $startDate;
        $schedule->end_date = $endDate;
        $schedule->from_start = $fromStart;
        $schedule->from_end = $fromEnd;
        $schedule->to_start = $toStart;
        $schedule->to_end = $toEnd;
        $schedule->updated_by = auth()->user()->id;
        $schedule->background = $request->background ?? $this->generateRandomColor();
        $schedule->save();

        return response()->json('Horario actualizado correctamente.', 200);
    }


    // group
    public function groupUpdate(Request $request, $id)
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

        return response()->json('Grupo de horario actualizado correctamente.', 200);
    }

    public function group(Request $request)
    {
        $request->validate([
            'name' => ['max:255', 'required', 'string'],
        ]);

        $group = GroupSchedule::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);
        return response()->json('Grupo de horario creado correctamente.', 200);
    }

    public function groupDefault($id)
    {
        $group = GroupSchedule::find($id);
        $groups = GroupSchedule::where('default', true)->get();
        if (!$group)  return response()->json('Group not found', 404);

        foreach ($groups as $g) {
            $g->default = false;
            $g->save();
        }

        $group->default = true;
        $group->save();

        return response()->json('Grupo de horario predeterminado actualizado correctamente.', 200);
    }

    public function remove($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json('Schedule not found', 404);
        }

        $schedule->delete();
        return response()->json('Horario eliminado correctamente.', 200);
    }

    public function archive($id)
    {
        $schedule = Schedule::find($id);
        $schedule->archived = true;
        $schedule->end_date = Carbon::now();
        $schedule->save();
        return response()->json('Horario archivado correctamente.', 200);
    }

    public function groupSchedules($id)
    {
        $group_schedule = GroupSchedule::find($id);
        $schedules = $group_schedule->allSchedules()->orderBy('from', 'asc')->get();
        return response()->json($schedules, 200);
    }

    public function groupDelete($id)
    {
        $group = GroupSchedule::find($id);
        if (!$group) {
            return response()->json('Group not found', 404);
        }

        $alreadyUsedCount = $group->schedules()->count();
        $alreadyUsersCount = $group->users()->count();


        if ($alreadyUsedCount > 0) {
            $for = $alreadyUsedCount == 1 ? 'un horario' : $alreadyUsedCount . ' horarios';
            return response()->json('No se puede eliminar el grupo porque ya está siendo usado por ' . $for . '.', 400);
        }

        if ($alreadyUsersCount > 0) {
            $for = $alreadyUsersCount == 1 ? 'un usuario' : $alreadyUsersCount . ' usuarios';
            return response()->json('No se puede eliminar el grupo porque ya está siendo usado por ' . $for . '.', 400);
        }

        $group->delete();
        return response()->json('Grupo de horario eliminado correctamente', 200);
    }

    // utls

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
}
