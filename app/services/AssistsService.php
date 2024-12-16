<?php

namespace App\services;

use App\Models\AssistTerminal;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserTerminal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AssistsService
{

    public static function getUsers($query, $area_id, $department_id, $limit = 10)
    {
        $match = User::orderBy('created_at', 'desc')->where('status', true);

        if ($area_id) {
            $match->whereHas('role_position', function ($q) use ($area_id) {
                $q->whereHas('department', function ($qq) use ($area_id) {
                    $qq->where('id_area', $area_id);
                });
            });
        }

        if ($department_id) {
            $match->whereHas('role_position', function ($q) use ($department_id) {
                $q->where('id_department', $department_id);
            });
        }

        if ($query) {
            $match->where('full_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%');
        }

        return [
            'getLimited' => $match->limit($limit)->get(),
            'total' => $match->count()
        ];
    }

    public static function centralized($query, $terminalsIds, $startDate, $endDate, $area_id, $department_id)
    {


        if (count($terminalsIds) == 0) {
            session()->flash('warning', 'Por favor seleccione al menos un terminal.');
            return ['assists' => [], 'total' => 0, 'totalUsers' => 0, 'usersShown' => 0];
        }

        if (!$startDate || !$endDate) {
            session()->flash('warning', 'Por favor seleccione un rango de fechas.');
            return ['assists' => [], 'total' => 0, 'totalUsers' => 0, 'usersShown' => 0];
        }

        $userTerminals = AssistTerminal::whereIn('id', $terminalsIds)->get();
        $users = self::getUsers($query, $area_id, $department_id);
        $userIds = $users['getLimited']->pluck('id')->toArray();

        $allUserTerminals = UserTerminal::whereIn('user_id', $userIds)->get()->map(function ($item) {
            return $item->assistTerminal;
        })->unique('assist_terminal_id');

        $totalCount = 0;
        $assists = [];

        $attendances = [];
        foreach ($allUserTerminals as $userTerminal) {
            $attendances = array_merge($attendances, DB::connection($userTerminal->database_name)
                ->table('iclock_transaction as it')
                ->join('personnel_employee as pe', 'it.emp_code', '=', 'pe.emp_code')
                ->select('it.id', 'it.punch_time', 'it.upload_time', 'pe.emp_code')
                ->whereBetween(DB::raw('CAST(it.punch_time AS DATE)'), [$startDate, $endDate])
                ->orderBy('it.punch_time', 'desc')
                ->whereIn('pe.emp_code', $userIds)
                ->get()->toArray());
        }

        foreach ($users['getLimited'] as $user) {
            $schedules = self::generateSchedules($user, $startDate, $endDate);
            // $matchets = [];
            // foreach ($schedules as $schedule) {
            //     $totalCount += 1;

            //     // $from = $schedule['from'];
            //     // $fromStart = $schedule['from_start'];
            //     // $fromEnd = $schedule['from_end'];
            //     // $to = $schedule['to'];
            //     // $toStart = $schedule['to_start'];
            //     // $toEnd = $schedule['to_end'];

            //     // $entryKey = $attendances->filter(function ($assistance) use ($fromStart, $fromEnd) {
            //     //     $time = Carbon::parse($assistance->punch_time);
            //     //     return $time->between($fromStart, $fromEnd);
            //     // })->sortBy(function ($assistance) use ($from) {
            //     //     return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($from));
            //     // })->keys()->first();

            //     // $entry = $entryKey !== null ? $attendances->pull($entryKey) : null;

            //     // $exitKey = $attendances->filter(function ($assistance) use ($toStart, $toEnd) {
            //     //     $time = Carbon::parse($assistance->punch_time);
            //     //     return $time->between($toStart, $toEnd);
            //     // })->sortBy(function ($assistance) use ($to) {
            //     //     return abs(Carbon::parse($assistance->punch_time)->diffInSeconds($to));
            //     // })->keys()->first();

            //     // $exit = $exitKey !== null ? $attendances->pull($exitKey) : null;

            //     // $schedule['marked_in'] = $entry ? Carbon::parse($entry->punch_time)->format('H:i:s') : null;
            //     // $schedule['marked_out'] = $exit ? Carbon::parse($exit->punch_time)->format('H:i:s') : null;
            //     $schedule['terminal'] = $terminal;

            //     // $observations = [];
            //     // $owesTime = null;

            //     // if (!$entry) {
            //     //     $observations[] = 'No marcó entrada';
            //     // } elseif (Carbon::parse($entry->punch_time)->gt($from)) {
            //     //     $observations[] = 'Tardanza';
            //     // }

            //     // if (!$exit) {
            //     //     $observations[] = 'No marcó salida';
            //     // } elseif (Carbon::parse($exit->punch_time)->lt($to)) {
            //     //     $observations[] = 'Salida Temprana';
            //     // }

            //     // if ($entry && $exit) {
            //     //     if (Carbon::parse($entry->punch_time)->lte($from) && Carbon::parse($exit->punch_time)->gte($to)) {
            //     //         $observations[] = null;
            //     //         $owesTime = 0;
            //     //     } else {
            //     //         if (Carbon::parse($entry->punch_time)->gt($from)) {
            //     //             $owesTime = Carbon::parse($entry->punch_time)->diffInMinutes($from);
            //     //         } else $owesTime = 0;
            //     //         if (Carbon::parse($exit->punch_time)->lt($to)) {
            //     //             $owesTime += $to->diffInMinutes(Carbon::parse($exit->punch_time));
            //     //         }
            //     //     }
            //     // }
            //     // $schedule['observations'] = implode(', ', $observations);
            //     // $schedule['owes_time'] = is_numeric($owesTime) ? gmdate('H:i:s', $owesTime * 60) : null;
            //     $matchets[] = $schedule;
            // }
            $assists = array_merge($assists, $schedules);
        }


        return [
            'assists' => $assists,
            'total' => count($assists),
            'totalUsers' => $users['total'],
            'usersShown' => $users['getLimited']->count(),
        ];
    }

    public static function centralizedWithoutCalculating($query, $terminalsIds, $startDate, $endDate, $area_id, $department_id)
    {


        if (count($terminalsIds) == 0) {
            session()->flash('warning', 'Por favor seleccione al menos un terminal.');
            return ['assists' => [], 'total' => 0];
        }

        if (!$startDate || !$endDate) {
            session()->flash('warning', 'Por favor seleccione un rango de fechas.');
            return ['assists' => [], 'total' => 0];
        }


        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();
        $users = self::getUsers($query, $area_id, $department_id);
        $usersIds =  $users['getLimited']->pluck('dni')->toArray();
        
        $assists = Collect([]);
        $totalCount = 0;

        foreach ($terminals as $terminal) {

            $attendanceQuery = DB::connection($terminal->database_name)
                ->table('iclock_transaction as it')
                ->join('personnel_employee as pe', 'it.emp_code', '=', 'pe.emp_code')
                ->select('it.id', 'it.punch_time', 'it.upload_time', 'pe.emp_code')
                ->whereBetween(DB::raw('CAST(it.punch_time AS DATE)'), [$startDate, $endDate])
                ->orderBy('it.punch_time', 'desc')
                ->whereIn('pe.emp_code', $usersIds);

            $matched = $attendanceQuery->get();

            $totalCount += count($matched);

            $firstFive = $attendanceQuery->limit(5)->get();

            foreach ($firstFive as $item) {
                $user = $users['getLimited']->where('dni', $item->emp_code)->first();
                if (!$user) continue;
                $assists[] = [
                    'id' => $item->id,
                    'user' => $user,
                    'date' => Carbon::parse($item->punch_time)->format('d-m-Y'),
                    'day' => Carbon::parse($item->punch_time)->isoFormat('dddd'),
                    'time' => Carbon::parse($item->punch_time)->format('H:i:s'),
                    'sync_date' => Carbon::parse($item->upload_time)->format('d-m-Y H:i:s'),
                    'terminal' => $terminal,
                    'terminal_id' => $terminal->id,
                    'day' => Carbon::parse($item->punch_time)->isoFormat('dddd'),
                    'date' => Carbon::parse($item->punch_time)->format('d-m-Y'),
                ];
            }
        }

        return [
            'assists' => $assists,
            'total' => $totalCount
        ];
    }

    public static function withoutCalculating($query, $terminalsIds, $startDate, $endDate)
    {


        if (count($terminalsIds) == 0) {
            session()->flash('warning', 'Por favor seleccione al menos un terminal.');
            return ['assists' => [], 'total' => 0];
        }

        if (!$startDate || !$endDate) {
            session()->flash('warning', 'Por favor seleccione un rango de fechas.');
            return ['assists' => [], 'total' => 0];
        }


        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();

        $assists = collect();

        $totalCount = 0;

        foreach ($terminals as $terminal) {
            $attendanceQuery = DB::connection($terminal->database_name)
                ->table('iclock_transaction as it')
                ->join('personnel_employee as pe', 'it.emp_code', '=', 'pe.emp_code')
                ->select('it.id', 'it.punch_time', 'it.upload_time', 'pe.emp_code', 'pe.first_name', 'pe.last_name')
                ->whereBetween(DB::raw('CAST(it.punch_time AS DATE)'), [$startDate, $endDate])
                ->orderBy('it.punch_time', 'desc');

            if ($query) {
                $attendanceQuery->where(function ($q) use ($query) {
                    $q->where('pe.first_name', 'like', '%' . $query . '%')
                        ->orWhere('pe.last_name', 'like', '%' . $query . '%')
                        ->orWhere('pe.emp_code', 'like', '%' . $query . '%');
                });
            }

            $matched = $attendanceQuery->get();

            $totalCount += count($matched);

            $firstFive = $attendanceQuery->limit(5)->get();

            $assists = $assists->merge($firstFive->map(function ($item) use ($terminal) {
                $punchTime = Carbon::parse($item->punch_time);
                return [
                    'id' => $item->id,
                    'date' => $punchTime->format('d-m-Y'),
                    'day' => $punchTime->isoFormat('dddd'),
                    'employee_code' => $item->emp_code,
                    'employee_name' => $item->first_name . ' ' . $item->last_name,
                    'time' => $punchTime->format('H:i:s'),
                    'sync_date' => Carbon::parse($item->upload_time)->format('d-m-Y H:i:s'),
                    'terminal' => $terminal,
                ];
            }));
        }

        return [
            'assists' => $assists,
            'total' => $totalCount
        ];
    }

    public static function singleSummary($terminal, $startDate, $endDate)
    {
        $dates = [];
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        for ($date = $end; $date->gte($start); $date->subDay()) {
            $dates[] = $date->toDateString();
        }

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

    public static function generateSchedules($user, $startDate, $endDate)
    {
        $schedules = Schedule::where('user_id', $user->id)->where('start_date', '<=', $endDate)->where('end_date', '>=', $startDate)->get();

        $schedulesGenerated = [];

        foreach ($schedules as $schedule) {
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
                        // 'turn' => $schedule->from->hour >= 12 ? 'TT' : 'TM',
                        'turn' => 'TM',
                        'title' => $schedule->title,
                        'date' => $date,
                        'marked_in' => null,
                        'marked_out' => null,
                        'terminal' => null,
                        'observations' => null,
                        'owes_time' => null,
                        // 'from' => $schedule->from->setDateFrom($date),
                        // 'from_start' => $schedule->from_start->setDateFrom($date),
                        // 'from_end' => $schedule->from_end->setDateFrom($date),
                        // 'to' => $schedule->to->setDateFrom($date),
                        // 'to_start' => $schedule->to_start->setDateFrom($date),
                        // 'to_end' => $schedule->to_end->setDateFrom($date),
                        'from' => $schedule->from,
                        'from_start' => $schedule->from_start,
                        'from_end' => $schedule->from_end,
                        'to' => $schedule->to,
                        'to_start' => $schedule->to_start,
                        'to_end' => $schedule->to_end,
                        'created_at' => $schedule->created_at,
                        'updated_at' => $schedule->updated_at,
                    ];
                }
            }
        }

        // $schedules = array_filter($schedulesGenerated, function ($schedule) use ($startDate, $endDate) {
        //     return $schedule['date']->between($startDate, $endDate);
        // });

        // usort($schedules, function ($a, $b) {
        //     return strcmp($a['date'], $b['date']);
        // });

        return  $schedulesGenerated;
    }
}
