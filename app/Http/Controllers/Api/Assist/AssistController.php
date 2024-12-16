<?php

namespace App\Http\Controllers\Api\Assist;

use App\Http\Controllers\Controller;
use App\Jobs\AssistsWithoutUsers;
use App\Models\AssistTerminal;
use App\Models\User;
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
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');
        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        $userOnlyDocumentIds = $users->pluck('documentId')->toArray();

        foreach ($terminals as $terminal) {
            $databaseName = $terminal->databaseName;
            $query = "
                SELECT 
                    it.punch_time AS datetime, 
                    pe.emp_code AS documentId, 
                    '$terminal->id' AS terminalId
                    FROM 
                        [$databaseName].dbo.iclock_transaction AS it
                    JOIN 
                        [$databaseName].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                    WHERE 
                        it.punch_time >= '$plainStartDate' 
                        AND it.punch_time < '$plainEndDate'
                        AND pe.emp_code IN (" . implode(',', $userOnlyDocumentIds) . ")
                ";

            if ($q) {
                $query .= " AND (pe.first_name LIKE '%$q%' OR pe.last_name LIKE '%$q%' OR pe.emp_code LIKE '%$q%')";
            }

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

        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        foreach ($terminals as $terminal) {
            $databaseName = $terminal->databaseName;
            // Construir la consulta base
            $query = "
        SELECT 
            it.punch_time AS datetime, 
            pe.emp_code AS documentId, 
            pe.first_name AS firstNames, 
            pe.last_name AS lastNames,
            '$databaseName' AS databaseName,
            '$terminal->id' AS terminalId
            FROM 
                [$databaseName].dbo.iclock_transaction AS it
            JOIN 
                [$databaseName].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
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

        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');

        AssistsWithoutUsers::dispatch($q, $terminalsIds, $startDate, $endDate, Auth::id());

        return response()->json('The report is being processed, you will be notified by email once it is ready');
    }
}
