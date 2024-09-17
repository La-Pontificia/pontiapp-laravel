<?php

namespace App\services;

use App\Models\AssistTerminal;
use App\Models\Attendance;
use App\Models\AttendanceEmp;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AssistsService
{

    public static function generateSchedules($user, $startDate, $endDate)
    {
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
                        'user' => $user,
                        'job_position' => $user->role_position->job_position->name,
                        'role' => $user->role_position->name,
                        'day' => $date->isoFormat('dddd'),
                        'turn' => Carbon::parse($schedule->from)->hour >= 12 ? 'TT' : 'TM',
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

        $schedules = array_filter($schedulesGenerated, function ($schedule) use ($startDate, $endDate) {
            $date = Carbon::parse($schedule['date']);
            return $date->between(Carbon::parse($startDate), Carbon::parse($endDate));
        });

        usort($schedules, function ($a, $b) {
            return strcmp($a['date'], $b['date']);
        });

        return $schedules;
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
                        'date' => $date->format('d/m/Y'),
                        'day' => $date->isoFormat('dddd'),
                        'turn' => Carbon::parse($schedule->from)->hour >= 12 ? 'TT' : 'TM',
                        'from' => Carbon::parse($schedule->from)->setDateFrom($date)->format('d/m/Y H:i:s'),
                        'from_start' => Carbon::parse($schedule->from_start)->setDateFrom($date)->format('d/m/Y H:i:s'),
                        'from_end' => Carbon::parse($schedule->from_end)->setDateFrom($date)->format('d/m/Y H:i:s'),
                        'to' => Carbon::parse($schedule->to)->setDateFrom($date)->format('d/m/Y H:i:s'),
                        'to_start' => Carbon::parse($schedule->to_start)->setDateFrom($date)->format('d/m/Y H:i:s'),
                        'to_end' => Carbon::parse($schedule->to_end)->setDateFrom($date)->format('d/m/Y H:i:s'),
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

    public static function assistsByUser($user, $terminalsIds, $startDate, $endDate)
    {

        $terminals = $user->assistTerminals;

        if (count($terminalsIds) > 0) {
            $terminals = [];
            foreach ($terminalsIds as $terminalId) {
                $terminals[] = AssistTerminal::find($terminalId);
            }
        }

        $schedules = self::generateSchedules($user, $startDate, $endDate);
        $assists = [];
        foreach ($terminals as $terminal) {
            // conection to the terminal
            $data = (new Attendance())
                ->setConnection($terminal->assistTerminal->database_name)
                ->where('emp_code', $user->dni)
                ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
                ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
                ->orderBy('punch_time', 'asc')
                ->get();

            $list = [];
            $schedules = self::generateSchedules($user, $startDate, $endDate);

            foreach ($schedules as $schedule) {
                $from = Carbon::parse($schedule['from']);
                $fromStart = Carbon::parse($schedule['from_start']);
                $fromEnd = Carbon::parse($schedule['from_end']);
                $to = Carbon::parse($schedule['to']);
                $toStart = Carbon::parse($schedule['to_start']);
                $toEnd = Carbon::parse($schedule['to_end']);

                // Find the nearest entry within the range
                $entryKey = $data->filter(function ($assistance) use ($fromStart, $fromEnd) {
                    $time = Carbon::parse($assistance->punch_time);
                    return $time->between($fromStart, $fromEnd);
                })->sortBy(function ($assistance) use ($from) {
                    return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($from));
                })->keys()->first();

                // Extract the entry from the array
                $entry = $entryKey !== null ? $data->pull($entryKey) : null;

                // Find the nearest exit within range
                $exitKey = $data->filter(function ($assistance) use ($toStart, $toEnd) {
                    $time = Carbon::parse($assistance->punch_time);
                    return $time->between($toStart, $toEnd);
                })->sortBy(function ($assistance) use ($to) {
                    return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($to));
                })->keys()->first();

                // Extract the exit from the array
                $exit = $exitKey !== null ? $data->pull($exitKey) : null;


                $schedule['marked_in'] = $entry ? Carbon::parse($entry->punch_time)->format('H:i:s') : null;
                $schedule['marked_out'] = $exit ? Carbon::parse($exit->punch_time)->format('H:i:s') : null;
                $schedule['terminal'] = $terminal->assistTerminal->name;

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

                $list[] = $schedule;
            }

            // concatenar la list a la lista de asistencias
            $assists = array_merge($assists, $list);
        }

        return $assists;
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

        $match = (new AttendanceEmp())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('emp_code', 'like', '%' . $query . '%')
            ->orderBy('id', 'desc')
            ->get();

        $users = [];

        if (!$query) {
            $users = $match->limit(25)->get();
        } else {
            $users = $match->get();
        }

        return $users;
    }

    public static function assists($query, $terminalsIds, $startDate, $endDate, $isExport = false)
    {

        $terminals = [];
        $users = User::all();

        if (count($terminalsIds) > 0) {
            foreach ($terminalsIds as $terminalId) {
                $terminals[] = AssistTerminal::find($terminalId);
            }
        } else {
            $terminals = AssistTerminal::limit(1)->get();
        }

        $assists = Collect([]);

        foreach ($terminals as $terminal) {

            $userDnis = $users->pluck('dni')->toArray();

            $match = (new Attendance())
                ->setConnection($terminal->database_name)
                ->whereHas('employee', function ($q) use ($query) {
                    $q->where('first_name', 'like', '%' . $query . '%')
                        ->orWhere('last_name', 'like', '%' . $query . '%')
                        ->orWhere('emp_code', 'like', '%' . $query . '%');
                })
                ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
                ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
                ->whereIn('emp_code', $userDnis)
                ->orderBy('punch_time', 'desc');

            $matched = [];

            if (!$query) {
                $matched = $match->limit(25)->get();
            } else {
                $matched = $match->get();
            }

            foreach ($matched as $item) {
                $user = User::where('dni', $item->emp_code)->first();
                if (!$user) continue;
                $assists[] = [
                    'id' => $item->id,
                    'user' => $user,
                    'date' => Carbon::parse($item->punch_time)->format('d-m-Y'),
                    'day' => Carbon::parse($item->punch_time)->isoFormat('dddd'),
                    'time' => Carbon::parse($item->upload_time)->format('H:i:s'),
                    'sync_date' => Carbon::parse($item->upload_time)->format('d-m-Y H:i:s'),
                    'terminal' => $terminal,
                    'terminal_id' => $terminal->id,
                    'day' => Carbon::parse($item->punch_time)->isoFormat('dddd'),
                    'date' => Carbon::parse($item->punch_time)->format('d-m-Y'),
                ];
            }
        }


        return $assists;
    }

    public static function singleSummary($terminal, $startDate, $endDate)
    {
        $dates = self::generateDateRange($startDate, $endDate);

        $assists = (new Attendance())
            ->setConnection($terminal ?? 'PL-Alameda')
            ->selectRaw("CAST(punch_time AS DATE) as punch_date, COUNT(*) as count")
            ->whereRaw("CAST(punch_time AS DATE) >= ?", [$startDate])
            ->whereRaw("CAST(punch_time AS DATE) <= ?", [$endDate])
            ->groupByRaw("CAST(punch_time AS DATE)")
            ->orderByRaw("CAST(punch_time AS DATE) desc")
            ->get()
            ->keyBy('punch_date');

        $summary = new Collection();

        foreach ($dates as $date) {
            $summary->push([
                'punch_date' => $date,
                'count' => $assists->has($date) ? $assists->get($date)->count : 0
            ]);
        }

        return $summary;
    }

    private static function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Decrementar el día en cada iteración para generar las fechas en orden descendente
        for ($date = $end; $date->gte($start); $date->subDay()) {
            $dates[] = $date->toDateString();
        }

        return $dates;
    }
}
