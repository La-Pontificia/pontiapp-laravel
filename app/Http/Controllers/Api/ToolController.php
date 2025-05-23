<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssistTerminal;
use App\Models\EventRecord;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function updateEventsRecords(Request $req)
    {
        $req->validate([
            'json' => 'required|array',
            'eventId' => 'required|string',
        ]);

        Log::info($req->json);

        $eventsRecords = EventRecord::where('eventId', $req->eventId)->get();
        $eventsRecords->each(function ($record) use ($req) {
            $person =  collect($req->json)->first(function ($person) use ($record) {
                return $person['documentId'] == $record->documentId;
            });
            if (!$person) return;
            $record->update([
                'fullName' => $person['names'],
                'career' => $person['career'],
            ]);
        });

        return response()->json('success');
    }

    public function downloadReportFile(Request $req, $id)
    {
        $filePath = 'file.jpg'; // Ruta relativa dentro de 'storage/app/public'

        // Obtener la ruta completa en el sistema de archivos
        $path = storage_path('app/public/' . $filePath);

        // Verificar si el archivo existe
        if (!file_exists($path)) {
            abort(404); // Si el archivo no existe, mostrar error 404
        }

        // Servir el archivo con el tipo adecuado (por ejemplo, imagen JPG)
        return response()->file($path, [
            'Content-Type' => 'image/jpeg',  // Tipo de contenido para imagen JPG
        ]);
    }
}
