<?php

namespace App\Http\Controllers\Api\Assist;

use App\Http\Controllers\Controller;
use App\Jobs\Assists;
use App\Jobs\AssistsWithoutUsers;
use App\Jobs\AssistsWithUsers;
use App\Models\AssistTerminal;
use App\Models\User;
use Carbon\Carbon;
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

        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $areaId = $req->get('areaId');
        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

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
                    ->orWhere('displayName', 'LIKE', "%$q%");
            });
        }

        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();
        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        $queryUsers->whereHas('schedules', function ($query) use ($startDate, $endDate, $terminalsIds) {
            $query->whereIn('assistTerminalId', $terminalsIds)
                ->where('startDate', '<=', $startDate)
                ->where(function ($query) use ($endDate) {
                    $query->where('endDate', '>=', $endDate)
                        ->orWhereNull('endDate');
                });
        });

        $users = $queryUsers->with('schedules')
            ->get();

        if ($users->isEmpty()) return response()->json([]);

        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        $userOnlyDocumentIds = $users->pluck('documentId')->toArray();

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
        $results = collect(DB::connection('sqlsrv_dynamic')->select($finalSql));

        $schedules = $users->pluck('schedules')->flatten();

        $firstAssistsBySchedules = collect([]);

        foreach ($schedules as $schedule) {
            $start = $startDate < $schedule->startDate ? Carbon::parse($schedule->startDate) : Carbon::parse($startDate);
            $end = $schedule->endDate ? ($endDate > $schedule->endDate ? Carbon::parse($schedule->endDate) : Carbon::parse($endDate)) : Carbon::parse($endDate);

            $days = collect($schedule->days);

            $assists = $results->filter(function ($result) use ($schedule) {
                return $result->documentId == $schedule->user->documentId && $result->terminalId == $schedule->assistTerminalId;
            });

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

                // Si el día de la semana está en los días de la semana del horario
                if ($days->contains($date->dayOfWeekIso)) {
                    $from = Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day);
                    $to = Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day);

                    $entryRangeStart = $from->copy()->subHour(2);
                    $entryRangeEnd = $from->copy()->addHour(2);

                    $exitRangeStart = $to->copy()->subHour(2);
                    $exitRangeEnd = $to->copy()->addHour(2);

                    $dailyAssists = $assists->filter(function ($assist) use ($date) {
                        return Carbon::parse($assist->datetime)->isSameDay($date);
                    });


                    // Buscar entrada más cercana al rango
                    $entry = $dailyAssists->filter(function ($assist) use ($entryRangeStart, $entryRangeEnd) {
                        $datetime = Carbon::parse($assist->datetime);
                        return $datetime->between($entryRangeStart, $entryRangeEnd);
                    })->sortBy(function ($assist) use ($from) {
                        return abs(Carbon::parse($assist->datetime)->diffInSeconds($from));
                    })->first();

                    if ($entry) {
                        $assists = $assists->reject(function ($assist) use ($entry) {
                            return $assist->id === $entry->id;
                        });
                        $results = $results->reject(function ($result) use ($entry) {
                            return $result->id === $entry->id;
                        });
                        $dailyAssists = $dailyAssists->reject(function ($assist) use ($entry) {
                            return $assist->id === $entry->id;
                        });
                    }

                    // Buscar salida más cercana al rango
                    $exit = $dailyAssists->filter(function ($assist) use ($exitRangeStart, $exitRangeEnd) {
                        $datetime = Carbon::parse($assist->datetime);
                        return $datetime->between($exitRangeStart, $exitRangeEnd);
                    })->sortBy(function ($assist) use ($to) {
                        return abs(Carbon::parse($assist->datetime)->diffInSeconds($to));
                    })->first();

                    if ($exit) {
                        $assists = $assists->reject(function ($assist) use ($exit) {
                            return $assist->id === $exit->id;
                        });
                        $results = $results->reject(function ($result) use ($exit) {
                            return $result->id === $exit->id;
                        });

                        $dailyAssists = $dailyAssists->reject(function ($assist) use ($exit) {
                            return $assist->id === $exit->id;
                        });
                    }


                    $firstAssistsBySchedules[] = [
                        'date' => $date->copy(),
                        'from' => $from,
                        'to' => $to,
                        'user' => $schedule->user,
                        'terminal' => $terminals->where('id', $schedule->assistTerminalId)->first(),
                        'markedIn' => $entry ? $entry->datetime : null,
                        'markedOut' => $exit ? $exit->datetime : null,
                    ];
                }
            }
        }

        // $firstAssistsBySchedules = collect($firstAssistsBySchedules)->shuffle();
        $firstAssistsBySchedules = collect($firstAssistsBySchedules)->sortByDesc('date')->values();

        $restAssists = $results->map(function ($assist) use ($terminals) {
            $assist->terminal = $terminals->where('id', $assist->terminalId)->first();
            $assist->user = User::where('documentId', $assist->documentId)->first();
            return $assist;
        });

        return response()->json([
            'matchedAssists' => $firstAssistsBySchedules,
            'restAssists' => $restAssists->values(),
        ]);
    }
    public function indexReport(Request $req)
    {

        $terminalsIds = $req->get('assistTerminals') ? explode(',', $req->get('assistTerminals')) : [];
        $startDate = $req->get('startDate');
        $endDate = $req->get('endDate');
        $q = $req->get('q');
        $jobId = $req->get('jobId');
        $areaId = $req->get('areaId');

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        if (empty($terminalsIds) || !$startDate || !$endDate) {
            return response()->json('Invalid parameters', 400);
        }

        $terminals = AssistTerminal::whereIn('id', $terminalsIds)->get();

        if ($terminals->isEmpty())
            return response()->json('No terminals found', 404);

        Assists::dispatch($q, $terminalsIds, $startDate, $endDate, $jobId, $areaId, Auth::id());

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
                    ->orWhere('displayName', 'LIKE', "%$q%");
            });
        }

        $users = $queryUsers->get();

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
            $result->user = $users->where('documentId', $result->documentId)->first();
            $result->terminal = $terminals->where('id', $result->terminalId)->first();
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
