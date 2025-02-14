<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\AssistTerminal;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsWithoutUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $q;
    public $terminalsIds;
    public $startDate;
    public $endDate;
    public $userId;


    public function __construct($q, $terminalsIds, $startDate, $endDate, $userId)
    {
        $this->q = $q;
        $this->terminalsIds = $terminalsIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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

        foreach ($terminals as $terminal) {
            $database = $terminal->database;
            $query = "
                    SELECT 
                        it.punch_time AS datetime, 
                        pe.emp_code AS documentId, 
                        pe.first_name AS firstNames, 
                        pe.last_name AS lastNames,
                        '$terminal->id' AS terminalId
                        FROM 
                            [$database].dbo.iclock_transaction AS it
                        JOIN 
                            [$database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                        WHERE 
                            it.punch_time >= '$plainStartDate' 
                            AND it.punch_time < '$plainEndDate'
                    ";
            if ($this->q) {
                $query .= " AND (pe.first_name LIKE '%$this->q%' OR pe.last_name LIKE '%$this->q%' OR pe.emp_code LIKE '%$this->q%')";
            }
            $unionQueries[] = $query;
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = DB::connection('sqlsrv_dynamic')->select($finalSql);

        foreach ($results as $result) {
            $assist = (array) $result;
            $assist['terminal'] = $terminals->firstWhere('id', $result->terminalId);
            $assists->push($assist);
        }

        $groupedAssists = $assists->groupBy(function ($assist) {
            return $assist['terminal']->id;
        })->map(function ($group) {
            return $group->groupBy('documentId')->map(function ($subGroup) {
                return $subGroup->groupBy('datetime');
            });
        });

        $spreadsheet = IOFactory::load(public_path('templates/assists_without_users.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $rr = 4;
        foreach ($groupedAssists as $terminalId => $employees) {
            foreach ($employees as $employeeCode => $dates) {
                foreach ($dates as $datetime => $assists) {
                    foreach ($assists as $assist) {
                        $lastNames = $assist['lastNames'] ? $assist['lastNames'] . ', ' : '';
                        $firstNames = $assist['firstNames'] ? $assist['firstNames'] : '';
                        $worksheet->setCellValue('B' . $rr, $rr - 3);
                        $worksheet->setCellValue('C' . $rr, $assist['terminal']?->name);
                        $worksheet->setCellValue('D' . $rr, $assist['documentId'] ?? "");
                        $worksheet->setCellValue('E' . $rr, $lastNames . $firstNames);
                        $worksheet->setCellValue('F' . $rr, Carbon::parse($assist['datetime'])->format('d/m/Y'));
                        $worksheet->getStyle('F' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $worksheet->setCellValue('G' . $rr, Carbon::parse($assist['datetime'])->isoFormat('dddd'));
                        $worksheet->setCellValue('H' . $rr, Carbon::parse($assist['datetime'])->format('H:i:s'));
                        $worksheet->getStyle('H' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $rr++;
                    }
                }
            }
        }

        foreach (range('B', 'H') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $fileName = 'assists_' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);
        $email = $user->email;

        SendEmail::dispatch('Reporte de asistencias finalizado.', 'Hola, el reporte de Asistencias sin usuarios del sistema ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, $email);

        event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de asistencias sin usuarios del sistema ya esta listo.', [
            'Descargar' => $downloadLink,
            'Ver' => '/m/assists/report-files',
        ]));

        Report::create([
            'title' => 'Registros de asistencias sin usuarios del sistema',
            'fileUrl' => $filePath,
            'downloadLink' => $downloadLink,
            'ext' => 'xlsx',
            'creatorId' => $user->id,
            'module' => 'assists',
        ]);
    }
}
