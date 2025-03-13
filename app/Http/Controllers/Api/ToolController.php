<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssistTerminal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ToolController extends Controller
{

    public function syncTerminalEmployee($terminalId)
    {
        $terminal = AssistTerminal::find($terminalId);

        if (!$terminal) return response()->json('not_found', 404);

        $query = "
            SELECT pe.emp_code AS documentId
                FROM [$terminal->database].dbo.personnel_employee as pe
                WHERE first_name IS NULL OR first_name = ''
                OR last_name IS NULL OR last_name = '';
        ";

        $results = collect(DB::connection('sqlsrv_dynamic')->select($query));

        $users = User::whereIn('documentId', $results->pluck('documentId'))->get();

        $updateQueries = [];

        $users->each(function ($user) use (&$updateQueries, $terminal) {
            $updateQueries[] = "
                UPDATE [$terminal->database].dbo.personnel_employee
                SET first_name = '$user->firstNames', last_name = '$user->lastNames', nickname = '$user->displayName'
                WHERE emp_code = '$user->documentId';
            ";
        });

        $combinedQuery = implode(" ", $updateQueries);
        DB::connection('sqlsrv_dynamic')->update($combinedQuery);

        return response()->json('success');
    }
}
