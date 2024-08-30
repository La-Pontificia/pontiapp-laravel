<?php

namespace App\services;

use App\Models\Attendance;
use App\Models\AttendanceEmp;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;


class AssistsService
{

    public static function generateSchedules($id, $startDate, $endDate)
    {
        $user = User::find($id);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $userSchedules = Schedule::where('user_id', $user->id)->where('start_date', '<=', $endDate)->where('end_date', '>=', $startDate)->get();
        $groupSchedules = Schedule::where('group_id', $user->group_schedule_id)->where('start_date', '<=', $endDate)->where('end_date', '>=', $startDate)->get();

        $allSchedules = $groupSchedules->merge($userSchedules);

        $schedulesGenerated = [];

        foreach ($allSchedules as $schedule) {
            $start = Carbon::parse($schedule->start_date);
            $end = Carbon::parse($schedule->end_date);
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (in_array($date->dayOfWeekIso, $schedule->days)) {
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

        return [
            'schedules' => $schedules,
            'user' => $user,
        ];
    }

    public static function generateSchedulesByGroup($user, $group_id, $startDate, $endDate)
    {
        $allSchedules = Schedule::where('group_id', $group_id)->where('start_date', '<=', $endDate)->where('end_date', '>=', $startDate)->get();

        $schedulesGenerated = [];

        foreach ($allSchedules as $schedule) {
            $start = Carbon::parse($schedule->start_date);
            $end = Carbon::parse($schedule->end_date);
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                if (in_array($date->dayOfWeekIso, $schedule->days)) {
                    $schedulesGenerated[] = [
                        'id' => $schedule->id,
                        'dni' => $user->emp_code,
                        'full_name' => $user->last_name . ', ' . $user->first_name,
                        'group_id' => $schedule->group_id,
                        'user_id' => $schedule->user_id,
                        'title' => $schedule->title,
                        'date' => $date->format('Y-m-d'),
                        'day' => $date->isoFormat('dddd'),
                        'turn' => Carbon::parse($schedule->from)->hour >= 12 ? 'TT' : 'TM',
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

        return $schedules;
    }

    public static function assistsByUser($id, $terminal, $startDate, $endDate)
    {
        $generated = self::generateSchedules($id, $startDate, $endDate);

        $user = $generated['user'];
        $schedules = $generated['schedules'];


        $assists = (new Attendance())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->where('emp_code', $user->dni)
            ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
            ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
            ->orderBy('punch_time', 'asc')
            ->get();

        foreach ($schedules as &$schedule) {
            $date = Carbon::parse($schedule['date']);
            $from = Carbon::parse($schedule['from']);
            $fromStart = Carbon::parse($schedule['from_start']);
            $fromEnd = Carbon::parse($schedule['from_end']);
            $to = Carbon::parse($schedule['to']);
            $toStart = Carbon::parse($schedule['to_start']);
            $toEnd = Carbon::parse($schedule['to_end']);

            // Find the nearest entry within the range
            $entryKey = $assists->filter(function ($assistance) use ($fromStart, $fromEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($fromStart, $fromEnd);
            })->sortBy(function ($assistance) use ($from) {
                return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($from));
            })->keys()->first();

            // Extract the entry from the array
            $entry = $entryKey !== null ? $assists->pull($entryKey) : null;

            // Find the nearest exit within range
            $exitKey = $assists->filter(function ($assistance) use ($toStart, $toEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($toStart, $toEnd);
            })->sortBy(function ($assistance) use ($to) {
                return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($to));
            })->keys()->first();

            // Extract the exit from the array
            $exit = $exitKey !== null ? $assists->pull($exitKey) : null;


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

    public static function assistsByEmployee($user, $group_id, $terminal, $startDate, $endDate)
    {
        $schedules = self::generateSchedulesByGroup($user, $group_id, $startDate, $endDate);

        $match = (new Attendance())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->where('emp_code', $user->emp_code)
            ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
            ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
            ->orderBy('punch_time', 'asc');

        $assists = $match->get();

        foreach ($schedules as &$schedule) {
            $date = Carbon::parse($schedule['date']);
            $from = Carbon::parse($schedule['from']);
            $fromStart = Carbon::parse($schedule['from_start']);
            $fromEnd = Carbon::parse($schedule['from_end']);
            $to = Carbon::parse($schedule['to']);
            $toStart = Carbon::parse($schedule['to_start']);
            $toEnd = Carbon::parse($schedule['to_end']);

            // Find the nearest entry within the range
            $entryKey = $assists->filter(function ($assistance) use ($fromStart, $fromEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($fromStart, $fromEnd);
            })->sortBy(function ($assistance) use ($from) {
                return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($from));
            })->keys()->first();

            // Extract the entry from the array
            $entry = $entryKey !== null ? $assists->pull($entryKey) : null;

            // Find the nearest exit within range
            $exitKey = $assists->filter(function ($assistance) use ($toStart, $toEnd) {
                $time = Carbon::parse($assistance->punch_time);
                return $time->between($toStart, $toEnd);
            })->sortBy(function ($assistance) use ($to) {
                return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($to));
            })->keys()->first();

            // Extract the exit from the array
            $exit = $exitKey !== null ? $assists->pull($exitKey) : null;

            // set values
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

    public static function employee($query, $terminal)
    {

        $users = (new AttendanceEmp())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('emp_code', 'like', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->get();

        return $users;
    }

    public static function assists($query, $terminal, $startDate, $endDate)
    {

        $assists = (new Attendance())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->whereHas('employee', function ($q) use ($query) {
                $q->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('emp_code', 'like', '%' . $query . '%');
            })
            ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
            ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
            ->orderBy('punch_time', 'desc')
            ->get();

        return $assists;
    }

    public static function singleSummary($terminal, $startDate, $endDate)
    {
        $assists = (new Attendance())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->selectRaw("CAST(punch_time AS DATE) as punch_date, COUNT(*) as count")
            ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
            ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
            ->groupByRaw("CAST(punch_time AS DATE)")
            ->orderByRaw("CAST(punch_time AS DATE) desc")
            ->get();

        return $assists;
    }
}
