<?php

namespace App\Http\Controllers\Api\Assist;

use App\Http\Controllers\Controller;
use App\Jobs\Assists;
use App\Jobs\AssistsWithoutUsers;
use App\Jobs\AssistsWithUsers;
use App\Models\AssistTerminal;
use App\Models\UserSchedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssistController extends Controller
{

    public static function relationShipUsers($relationShiptQuery, $limit = null)
    {
        $match = User::orderBy('created_at', 'desc');
        $includes = explode(',', $relationShiptQuery);
        if (in_array('role', $includes)) $match->with('role');
        if (in_array('role.job', $includes)) $match->with('role.job');
        if (in_array('role.department', $includes))  $match->with('role.department');
        if (in_array('role.department.area', $includes)) $match->with('role.department.area');
        if (in_array('manager', $includes)) $match->with('manager');
        if (in_array('manager.job', $includes)) $match->with('manager.job');
        if (in_array('manager.department', $includes))  $match->with('manager.department');
        if (in_array('manager.department.area', $includes)) $match->with('manager.department.area');
        if (in_array('schedules', $includes)) $match->with('schedules');
        if (in_array('schedules.terminal', $includes)) $match->with('schedules.terminal');
        if (in_array('userRole', $includes)) $match->with('userRole');
        if (in_array('contractType', $includes)) $match->with('contractType');
        if ($limit) $match->limit($limit);
        return $match;
    }

    // Assists methods
    public function index(Request $req)
    {
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $withUser = $req->get('withUser');
        $areaId = $req->get('areaId');

        if (!$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        $queryUsers = self::relationShipUsers($req->get('relationship'), $req->get('limit'));

        if ($areaId) {
            $queryUsers->whereHas('role', function ($query) use ($areaId) {
                $query->whereHas('department', function ($query) use ($areaId) {
                    $query->where('areaId', $areaId);
                });
            });
        }

        if ($jobId) {
            $queryUsers->whereHas('role', function ($query) use ($jobId) {
                $query->where('jobId', $jobId);
            });
        }

        if ($q) {
            $queryUsers->where('documentId', 'LIKE', "%$q%")
                ->orWhere('firstNames', 'LIKE', "%$q%")
                ->orWhere('lastNames', 'LIKE', "%$q%")
                ->orWhere('fullName', 'LIKE', "%$q%")
                ->orWhere('displayName', 'LIKE', "%$q%")
                ->orWhere('email', 'LIKE', "%$q%")
                ->orWhere('username', 'LIKE', "%$q%");
        }

        $terminals = AssistTerminal::all();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $users = $queryUsers
            ->whereHas('schedules')
            ->where('status', true)
            ->get();


        if ($users->isEmpty()) return response()->json(
            [
                'matchedAssists' => [],
                'restAssists' => [],
                'originalResultsCount' => 0
            ]
        );

        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        $userOnlyDocumentIds = $users->pluck('documentId')->toArray();
        $userOnlyIds = $users->pluck('id')->toArray();

        foreach ($terminals as $terminal) {
            $query = "
                      SELECT 
                          it.id AS id,
                          it.punch_time AS datetime, 
                          pe.emp_code AS documentId, 
                          '$terminal->id' AS terminalId
                          FROM 
                              [$terminal->database].dbo.iclock_transaction AS it
                          JOIN 
                              [$terminal->database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                          WHERE 
                              it.punch_time >= '$plainStartDate' 
                              AND it.punch_time <= '$plainEndDate'
                              AND pe.emp_code IN (" . implode(',', $userOnlyDocumentIds) . ")
                      ";
            $unionQueries[] = $query;
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = collect(DB::connection('sqlsrv_dynamic')->select($finalSql))->keyBy('id');

        $originalResultsCount = $results->count();

        $schedules = UserSchedule::whereIn('userId', $userOnlyIds)
            // ->where('startDate', '<=', $startDate)
            // ->where(function ($query) use ($endDate) {
            //     $query->where('endDate', '>=', $endDate)
            //         ->orWhereNull('endDate');
            // })
            ->get();

        $generatedSchedules = collect($schedules)->flatMap(function ($schedule) use ($startDate, $endDate) {
            $start = max(Carbon::parse($startDate), Carbon::parse($schedule->startDate));
            $end = $schedule->endDate ? min(Carbon::parse($endDate), Carbon::parse($schedule->endDate)) : Carbon::parse($endDate);

            return collect(Carbon::parse($start)->daysUntil($end))->filter(function ($date) use ($schedule) {
                return collect($schedule->days)->contains($date->dayOfWeekIso);
            })->map(function ($date) use ($schedule) {
                $from = Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day);
                $to = Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day);
                return [
                    'date' => $date,
                    'from' => $from->addMinutes($schedule->tolerance),
                    'to' => $to,
                    'userId' => $schedule->user->id,
                    'userDocumentId' => $schedule->user->documentId
                ];
            });
        })->values();

        $generatedSchedules = $generatedSchedules->sortBy('date');

        $groupedSchedules = $generatedSchedules
            ->groupBy('userId')
            ->flatMap(function ($userSchedules) {
                return $userSchedules->groupBy(fn($schedule) => $schedule['date']->format('Y-m-d'))
                    ->map(function ($dailySchedules) {
                        $firstSchedule = $dailySchedules->first();
                        $timeSlots = $dailySchedules->reduce(function ($slots, $schedule) {
                            $hour = $schedule['from']->format('H');
                            if ($hour < 12) {
                                $slots['morningFrom'] = $schedule['from'];
                                $slots['morningTo'] = $schedule['to'];
                            } else {
                                $slots['afternoonFrom'] = $schedule['from'];
                                $slots['afternoonTo'] = $schedule['to'];
                            }
                            return $slots;
                        }, [
                            'morningFrom' => null,
                            'morningTo' => null,
                            'afternoonFrom' => null,
                            'afternoonTo' => null,
                        ]);

                        return array_merge([
                            'date' => $firstSchedule['date']->format('Y-m-d'),
                            'userId' => $firstSchedule['userId'],
                            'userDocumentId' => $firstSchedule['userDocumentId']
                        ], $timeSlots, [
                            'morningMarkedIn' => null,
                            'morningMarkedOut' => null,
                            'afternoonMarkedIn' => null,
                            'afternoonMarkedOut' => null
                        ]);
                    })->values();
            })->values();

        $updatedSchedules = $groupedSchedules->map(function ($schedule) use ($results, $users, $withUser) {
            $dailyResults = $results->filter(
                fn($result) =>
                $result->documentId === $schedule['userDocumentId'] &&
                    Carbon::parse($result->datetime)->format('Y-m-d') === $schedule['date']
            )->keyBy('id');

            $calculateAttendance = function ($timeFrom, $timeTo, $dailyResults, $results, $rangeModifier) {
                if (!$timeFrom || !$timeTo) {
                    return [null, null];
                }

                $entryRangeStart = $timeFrom->copy()->sub($rangeModifier);
                $entryRangeEnd = $timeFrom->copy()->add($rangeModifier);
                $exitRangeStart = $timeTo->copy()->sub($rangeModifier);
                $exitRangeEnd = $timeTo->copy()->add($rangeModifier);

                $entry = $dailyResults->filter(
                    fn($assist) =>
                    Carbon::parse($assist->datetime)->between($entryRangeStart, $entryRangeEnd)
                )->sortBy(
                    fn($assist) =>
                    abs(Carbon::parse($assist->datetime)->diffInSeconds($timeFrom))
                )->first();

                if ($entry) {
                    unset($dailyResults[$entry->id]);
                    unset($results[$entry->id]);
                }

                $exit = $dailyResults->filter(
                    fn($assist) =>
                    Carbon::parse($assist->datetime)->between($exitRangeStart, $exitRangeEnd)
                )->sortBy(
                    fn($assist) =>
                    abs(Carbon::parse($assist->datetime)->diffInSeconds($timeTo))
                )->first();

                if ($exit) {
                    unset($dailyResults[$exit->id]);
                    unset($results[$exit->id]);
                }

                return [
                    $entry ? Carbon::parse($entry->datetime) : null,
                    $exit ? Carbon::parse($exit->datetime) : null,
                ];
            };

            [$morningMarkedIn, $morningMarkedOut] = $calculateAttendance(
                $schedule['morningFrom'],
                $schedule['morningTo'],
                $dailyResults,
                $results,
                CarbonInterval::minutes(180),

            );

            [$afternoonMarkedIn, $afternoonMarkedOut] = $calculateAttendance(
                $schedule['afternoonFrom'],
                $schedule['afternoonTo'],
                $dailyResults,
                $results,
                CarbonInterval::minutes(180),
            );

            // If there are still assists left, try to match them with the schedule
            // if ((!$morningMarkedIn || !$morningMarkedOut || !$afternoonMarkedIn || !$afternoonMarkedOut) && $dailyResults->isNotEmpty()) {
            //     $remainingEntry = $dailyResults->sortBy(
            //         fn($assist) => abs(Carbon::parse($assist->datetime)->diffInSeconds($schedule['morningFrom'] ?? $schedule['afternoonFrom']))
            //     )->first();

            //     if ($remainingEntry) {
            //         $entryTime = Carbon::parse($remainingEntry->datetime);

            //         if (!$morningMarkedIn && $entryTime < ($schedule['morningTo'] ?? $schedule['afternoonFrom'])) {
            //             $morningMarkedIn = $entryTime;
            //         } elseif (!$morningMarkedOut && $entryTime < ($schedule['afternoonFrom'] ?? $schedule['morningTo'])) {
            //             $morningMarkedOut = $entryTime;
            //         } elseif (!$afternoonMarkedIn && $entryTime >= ($schedule['morningTo'] ?? $schedule['afternoonFrom'])) {
            //             $afternoonMarkedIn = $entryTime;
            //         } elseif (!$afternoonMarkedOut) {
            //             $afternoonMarkedOut = $entryTime;
            //         }

            //         unset($dailyResults[$remainingEntry->id]);
            //         unset($results[$remainingEntry->id]);
            //     }
            // }

            if ($morningMarkedIn && !$morningMarkedOut && !$afternoonMarkedIn && $afternoonMarkedOut) {
                $morningMarkedOut = $schedule['morningTo'];
                $afternoonMarkedIn = $schedule['afternoonFrom'];
            }

            $user = $withUser ? $users->find($schedule['userId']) : null;

            return array_merge($schedule, [
                'user' => $user ? $user->only(['id', 'documentId', 'firstNames', 'lastNames', 'displayName', 'email', 'username', 'photoURL']) : null,
            ], [
                'morningMarkedIn' => $morningMarkedIn,
                'morningMarkedOut' => $morningMarkedOut,
                'afternoonMarkedIn' => $afternoonMarkedIn,
                'afternoonMarkedOut' => $afternoonMarkedOut,
            ]);
        });


        $restAssists = $results->map(function ($record) use ($terminals, $users) {
            $user = $users->where('documentId', $record->documentId)->first();
            $record->terminal = $terminals->where('id', $record->terminalId)->first();
            $record->user = $user ? $user->only(['id', 'documentId', 'firstNames', 'lastNames', 'displayName', 'email', 'username', 'photoURL']) : null;
            return $record;
        })->values();

        return response()->json([
            'matchedAssists' => $updatedSchedules,
            'restAssists' => $restAssists->sortBy('datetime')->values(),
            'originalResultsCount' => $originalResultsCount
        ]);
    }

    public function indexReport(Request $req)
    {
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $areaId = $req->get('areaId');

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        if (!$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $terminals = AssistTerminal::all();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        Assists::dispatch($q, $startDate, $endDate, $jobId, $areaId, Auth::id());

        return response()->json('The report is being processed, you will be notified by email once it is ready');
    }

    // WithUsers methods
    public function withUsers(Request $req)
    {
        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $areaId = $req->get('areaId');

        $queryUsers = self::relationShipUsers($req->get('relationship'), $req->get('limit'));

        if ($areaId) {
            $queryUsers->whereHas('role', function ($query) use ($areaId) {
                $query->whereHas('department', function ($query) use ($areaId) {
                    $query->where('areaId', $areaId);
                });
            });
        }

        if ($jobId) {
            $queryUsers->whereHas('role', function ($query) use ($jobId) {
                $query->where('jobId', $jobId);
            });
        }

        if ($q) {
            $queryUsers->where(function ($query) use ($q) {
                $query->where('documentId', 'LIKE', "%$q%")
                    ->orWhere('firstNames', 'LIKE', "%$q%")
                    ->orWhere('lastNames', 'LIKE', "%$q%")
                    ->orWhere('fullName', 'LIKE', "%$q%")
                    ->orWhere('displayName', 'LIKE', "%$q%")
                    ->orWhere('email', 'LIKE', "%$q%")
                    ->orWhere('username', 'LIKE', "%$q%");
            });
        }

        $users = $queryUsers->where('status', true)->get();

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }
        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();
        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');
        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        $userOnlyDocumentIds = $users->pluck('documentId')->toArray();

        foreach ($terminals as $terminal) {
            $query = "
                SELECT 
                    it.punch_time AS datetime, 
                    pe.emp_code AS documentId, 
                    '$terminal->id' AS terminalId
                    FROM 
                        [$terminal->database].dbo.iclock_transaction AS it
                    JOIN 
                        [$terminal->database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                    WHERE 
                        it.punch_time >= '$plainStartDate' 
                        AND it.punch_time < '$plainEndDate'
                        AND pe.emp_code IN (" . implode(',', $userOnlyDocumentIds) . ")
                ";
            $unionQueries[] = $query;
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = DB::connection('sqlsrv_dynamic')->select($finalSql);

        foreach ($results as $result) {
            $result->user = $users->where('documentId', $result->documentId)->first()->only(['id', 'documentId', 'firstNames', 'lastNames', 'displayName', 'email', 'username', 'photoURL']);
            $result->terminal = $terminals->where('id', $result->terminalId)->first()->only(['id', 'name']);
        }

        return response()->json($results);
    }
    public function withUsersReport(Request $req)
    {
        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $areaId = $req->get('areaId');

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        AssistsWithUsers::dispatch($q, $terminalsIds, $startDate, $endDate, $jobId, $areaId, Auth::id());

        return response()->json('The report is being processed, you will be notified by email once it is ready');
    }

    // WithoutUsers methods
    public function withoutUsers(Request $req)
    {
        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        foreach ($terminals as $terminal) {
            $query = "
                SELECT 
                    it.punch_time AS datetime, 
                    pe.emp_code AS documentId, 
                    pe.first_name AS firstNames, 
                    pe.last_name AS lastNames,
                    '$terminal->id' AS terminalId
                    FROM 
                        [$terminal->database].dbo.iclock_transaction AS it
                    JOIN 
                        [$terminal->database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                    WHERE 
                        it.punch_time >= '$plainStartDate' 
                        AND it.punch_time < '$plainEndDate'
                ";

            if ($q) {
                $query .= " AND (pe.first_name LIKE '%$q%' OR pe.last_name LIKE '%$q%' OR pe.emp_code LIKE '%$q%')";
            }

            $unionQueries[] = $query;
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = DB::connection('sqlsrv_dynamic')->select($finalSql);
        return response()->json($results);
    }
    public function withoutUsersReport(Request $req)
    {
        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        AssistsWithoutUsers::dispatch($q, $terminalsIds, $startDate, $endDate, Auth::id());

        return response()->json('The report is being processed, you will be notified by email once it is ready');
    }

    // Summary methods
    public function singleSummary(Request $req)
    {

        $assistTerminal = $req->get('assistTerminal');
        $startDate = $req->get('startDate', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $req->get('endDate', Carbon::now()->format('Y-m-d'));

        $terminal = AssistTerminal::find($assistTerminal);

        if (!$terminal) return response()->json('Terminal not found', 404);

        $dates = [];

        $currentDate = Carbon::parse($startDate);
        while ($currentDate <= Carbon::parse($endDate)) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $query = "
            WITH DateRange AS (
                SELECT CAST('$startDate' AS DATE) AS date
                UNION ALL
                SELECT DATEADD(DAY, 1, date)
                FROM DateRange
                WHERE date < '$endDate'
            )
            SELECT 
                d.date,
                COUNT(t.punch_time) AS count
            FROM 
                DateRange d
            LEFT JOIN 
                [$terminal->database].dbo.iclock_transaction t ON CONVERT(DATE, t.punch_time) = d.date
            GROUP BY 
                d.date
            ORDER BY 
                d.date
            OPTION (MAXRECURSION 0);
        ";

        $result = DB::connection('sqlsrv_dynamic')->select($query);

        $summary = collect($result)->map(function ($item) use ($terminal) {
            $item->terminal = $terminal;
            return $item;
        });

        return response()->json($summary);
    }

    // get all databases
    public function allDatabases()
    {
        $query = "
            SELECT 
            name AS name,
            state_desc AS state,
            recovery_model_desc AS recoveryModel,
            compatibility_level AS compatibilityLevel,
            collation_name AS collation,
            create_date AS created_at
        FROM 
            sys.databases
        WHERE 
            name NOT IN ('master', 'model', 'msdb', 'tempdb', 'ReportServer', 'ReportServerTempDB', '_sc');
        ";

        $databases = DB::connection('sqlsrv_dynamic')->select($query);
        return response()->json($databases);
    }
}
