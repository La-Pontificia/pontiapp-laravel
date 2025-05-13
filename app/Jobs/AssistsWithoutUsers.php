<?php

namespace App\Jobs;


use App\Models\AssistTerminal;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsWithoutUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $q,
        public $terminalsIds,
        public $startDate,
        public $endDate,
        public $userId
    ) {}

    public function handle(): void
    {
        $terminals = AssistTerminal::whereIn('id', $this->terminalsIds)->get();
        $assists = collect();

        $startDate = Carbon::parse($this->startDate)->format('Y-m-d');
        $endDate = Carbon::parse($this->endDate)->format('Y-m-d');

        $plainStartDate = "{$startDate}T00:00:00.000";
        $plainEndDate = "{$endDate}T23:59:59.999";

        $unionQueries = [];

        foreach ($terminals as $terminal) {
            $db = $terminal->database;
            $query = "
                SELECT 
                    it.punch_time AS datetime, 
                    pe.emp_code AS documentId, 
                    pe.first_name AS firstNames, 
                    pe.last_name AS lastNames,
                    '$terminal->id' AS terminalId
                FROM 
                    [$db].dbo.iclock_transaction AS it
                JOIN 
                    [$db].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                WHERE 
                    it.punch_time >= '$plainStartDate' 
                    AND it.punch_time < '$plainEndDate'
            ";
            if ($this->q) {
                $q = $this->q;
                $query .= " AND (pe.first_name LIKE '%$q%' OR pe.last_name LIKE '%$q%' OR pe.emp_code LIKE '%$q%')";
            }
            $unionQueries[] = $query;
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = DB::connection('sqlsrv_dynamic')->select($finalSql);

        foreach ($results as $res) {
            $assist = (array) $res;
            $assist['terminal'] = $terminals->firstWhere('id', $res->terminalId);
            $assists->push($assist);
        }

        $groupedAssists = $assists->groupBy(fn($a) => $a['terminal']->id)
            ->map(fn($g) => $g->groupBy('documentId')->map(fn($sg) => $sg->groupBy('datetime')));

        $spreadsheet = IOFactory::load(public_path('templates/assists_without_users.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();

        $row = 4;
        foreach ($groupedAssists as $employees) {
            foreach ($employees as $dates) {
                foreach ($dates as $assists) {
                    foreach ($assists as $a) {
                        $name = trim(($a['lastNames'] ? $a['lastNames'] . ', ' : '') . ($a['firstNames'] ?? ''));
                        $datetime = Carbon::parse($a['datetime']);
                        $sheet->setCellValue("B$row", $row - 3);
                        $sheet->setCellValue("C$row", $a['terminal']?->name);
                        $sheet->setCellValue("D$row", $a['documentId'] ?? "");
                        $sheet->setCellValue("E$row", $name);
                        $sheet->setCellValue("F$row", $datetime->format('d/m/Y'));
                        $sheet->getStyle("F$row")->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $sheet->setCellValue("G$row", $datetime->isoFormat('dddd'));
                        $sheet->setCellValue("H$row", $datetime->format('H:i:s'));
                        $sheet->getStyle("H$row")->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $row++;
                    }
                }
            }
        }

        Storage::makeDirectory('reports');
        $fileId = now()->timestamp;
        $filePath = "reports/{$fileId}.xlsx";

        IOFactory::createWriter($spreadsheet, 'Xlsx')->save(storage_path("app/{$filePath}"));

        $title = "{$this->startDate} - {$this->endDate} Asistencias sin usuarios del sistema";
        $report = Report::create([
            'fileId' => $fileId,
            'title' => $title,
            'ext' => 'xlsx',
            'creatorId' => $this->userId,
            'module' => 'assists',
        ]);

        $link = config('app.download_url') . "/reports/{$report->id}";
        ReportSendEmail::dispatch($report->title, 'asistencias', 'las asistencias', $link, $this->userId);
    }
}
