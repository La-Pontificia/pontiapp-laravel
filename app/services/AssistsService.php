<?php

namespace App\services;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AssistsService
{

    public static function assistsByUser($id, $terminals, $startDate, $endDate)
    {
        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);
        $groupSchedules = $user->group_schedule_id ? $user->groupSchedule->schedules : collect();

        $userSchedules = Schedule::where('user_id', $user->id)->get();

        $allSchedules = $groupSchedules->merge($userSchedules);

        $schedulesGenerated = [];

        foreach ($allSchedules as $schedule) {
            $start = Carbon::parse($schedule->start_date);
            $end = Carbon::parse($schedule->end_date);
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (in_array($date->dayOfWeekIso, json_decode($schedule->days))) {
                    $schedulesGenerated[] = [
                        'id' => $schedule->id,
                        'dni' => $user->dni,
                        'full_name' => $user->last_name . ', ' . $user->first_name,
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

        $assistances = collect();
        foreach ($terminals ?? ['PL-Alameda'] as $terminal) {
            $match = (new Attendance())
                ->setConnection($terminal)
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
        return $schedules;
    }
}
