<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\AssistTerminal;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsWithUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $q;
    public $terminalsIds;
    public $startDate;
    public $endDate;
    public $jobId;
    public $areaId;
    public $userId;


    public function __construct($q, $terminalsIds, $startDate, $endDate, $jobId, $areaId, $userId)
    {
        $this->q = $q;
        $this->terminalsIds = $terminalsIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->jobId = $jobId;
        $this->areaId = $areaId;
        $this->userId = $userId;
    }


    public function handle(): void
    {
        $terminals = AssistTerminal::whereIn('id', $this->terminalsIds)->get();
        $assists = collect();
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d',  $this->endDate)->format('Y-m-d');

        $plainStartDate = $startDate . 'T00:00:00.000';
        $plainEndDate = $endDate . 'T23:59:59.999';

        $queryUsers = User::orderBy('created_at');

        $jobId = $this->jobId;
        $areaId = $this->areaId;
        $q = $this->q;

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

        $userOnlyDocumentIds = $users->pluck('documentId')->toArray();

        foreach ($terminals as $terminal) {
            $database = $terminal->database;
            $query = "
                    SELECT 
                         it.punch_time AS datetime, 
                         pe.emp_code AS documentId, 
                         '$terminal->id' AS terminalId
                        FROM 
                            [$database].dbo.iclock_transaction AS it
                        JOIN 
                            [$database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
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
            $assist = $result;
            $assist->user = $users->where('documentId', $result->documentId)->first();
            $assist->terminal = $terminals->where('id', $result->terminalId)->first();
            $assists->push($assist);
        }

        $groupedAssists = $assists->groupBy(function ($assist) {
            return $assist->terminal->id;
        })->map(function ($group) {
            return $group->groupBy('documentId')->map(function ($subGroup) {
                return $subGroup->groupBy('datetime');
            });
        });

        $spreadsheet = IOFactory::load(public_path('templates/assists_with_users.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $rr = 4;
        foreach ($groupedAssists as $terminalId => $employees) {
            foreach ($employees as $employeeCode => $dates) {
                foreach ($dates as $date => $assists) {
                    foreach ($assists as $assist) {
                        $worksheet->setCellValue('B' . $rr, $rr - 3);
                        $worksheet->setCellValue('C' . $rr, $assist->terminal?->name ?? "");
                        $worksheet->setCellValue('D' . $rr, $assist->documentId);
                        $worksheet->setCellValue('E' . $rr, $assist->user?->lastNames . ', ' . $assist->user?->firstNames);
                        $worksheet->setCellValue('F' . $rr, $assist->user?->role?->name ?? "");
                        $worksheet->setCellValue('G' . $rr, $assist->user?->role?->job?->name ?? "");
                        $worksheet->setCellValue('H' . $rr, $assist->user?->role?->department?->name ?? "");
                        $worksheet->setCellValue('I' . $rr, $assist->user?->role?->department?->area?->name ?? "");
                        $worksheet->setCellValue('J' . $rr, Carbon::parse($assist->datetime)->isoFormat('dddd'));
                        $worksheet->setCellValue('K' . $rr, Carbon::parse($assist->datetime)->format('d/m/Y'));
                        $worksheet->getStyle('K' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $worksheet->setCellValue('L' . $rr, Carbon::parse($assist->datetime)->format('H:i:s'));
                        $worksheet->getStyle('L' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $rr++;
                    }
                }
            }
        }

        foreach (range('B', 'L') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $fileName = 'assists_' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);
        $email = $user->email;

        SendEmail::dispatch('Reporte de asistencias finalizado.', 'Hola, el reporte de Asistencias con usuarios ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, $email);

        event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de asistencias con usuario ya esta listo.', [
            'Descargar' => $downloadLink,
            'Ver' => '/m/assists/report-files',
        ]));

        Report::create([
            'title' => 'Registros de asistencias con usuarios.',
            'fileUrl' => $filePath,
            'downloadLink' => $downloadLink,
            'ext' => 'xlsx',
            'creatorId' => $user->id,
            'module' => 'assists',
        ]);
    }
}
