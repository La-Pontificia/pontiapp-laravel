<?php

namespace App\Jobs;

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
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsWithUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $q,
        public $terminalsIds,
        public $startDate,
        public $endDate,
        public $jobId,
        public $areaId,
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

        $query = User::orderBy('created_at')
            ->where('status', true)
            ->whereNotNull('documentId');

        if ($this->areaId) {
            $query->whereHas('role.department', fn($q) => $q->where('areaId', $this->areaId));
        }

        if ($this->jobId) {
            $query->whereHas('role', fn($q) => $q->where('jobId', $this->jobId));
        }

        if ($this->q) {
            $q = $this->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('documentId', 'LIKE', "%$q%")
                    ->orWhere('firstNames', 'LIKE', "%$q%")
                    ->orWhere('lastNames', 'LIKE', "%$q%")
                    ->orWhere('fullName', 'LIKE', "%$q%")
                    ->orWhere('displayName', 'LIKE', "%$q%")
                    ->orWhere('email', 'LIKE', "%$q%")
                    ->orWhere('username', 'LIKE', "%$q%");
            });
        }

        $users = $query->get();
        $docIds = $users->pluck('documentId')->map(fn($id) => "'$id'")->implode(',');

        $unionQueries = [];

        foreach ($terminals as $terminal) {
            $db = $terminal->database;
            $unionQueries[] = "
                SELECT 
                    it.punch_time AS datetime, 
                    pe.emp_code AS documentId, 
                    '$terminal->id' AS terminalId
                FROM 
                    [$db].dbo.iclock_transaction AS it
                JOIN 
                    [$db].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                WHERE 
                    it.punch_time >= '$plainStartDate' 
                    AND it.punch_time < '$plainEndDate'
                    AND pe.emp_code IN ($docIds)
            ";
        }

        $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
        $results = DB::connection('sqlsrv_dynamic')->select($finalSql);

        foreach ($results as $r) {
            $r->user = $users->firstWhere('documentId', $r->documentId);
            $r->terminal = $terminals->firstWhere('id', $r->terminalId);
            $assists->push($r);
        }

        $grouped = $assists->groupBy(fn($a) => $a->terminal->id)
            ->map(fn($g) => $g->groupBy('documentId')->map(fn($sg) => $sg->groupBy('datetime')));

        $sheet = IOFactory::load(public_path('templates/assists_with_users.xlsx'))->getActiveSheet();
        $row = 4;

        foreach ($grouped as $employees) {
            foreach ($employees as $dates) {
                foreach ($dates as $assists) {
                    foreach ($assists as $a) {
                        $u = $a->user;
                        $dt = Carbon::parse($a->datetime);
                        $sheet->setCellValue("B{$row}", $row - 3);
                        $sheet->setCellValue("C{$row}", $a->terminal?->name ?? '');
                        $sheet->setCellValue("D{$row}", $a->documentId);
                        $sheet->setCellValue("E{$row}", ($u?->lastNames ? "{$u->lastNames}, " : '') . $u?->firstNames);
                        $sheet->setCellValue("F{$row}", $u?->role?->name ?? '');
                        $sheet->setCellValue("G{$row}", $u?->role?->job?->name ?? '');
                        $sheet->setCellValue("H{$row}", $u?->role?->department?->name ?? '');
                        $sheet->setCellValue("I{$row}", $u?->role?->department?->area?->name ?? '');
                        $sheet->setCellValue("J{$row}", $dt->isoFormat('dddd'));
                        $sheet->setCellValue("K{$row}", $dt->format('d/m/Y'));
                        $sheet->getStyle("K{$row}")->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $sheet->setCellValue("L{$row}", $dt->format('H:i:s'));
                        $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $row++;
                    }
                }
            }
        }

        Storage::makeDirectory('reports');
        $fileId = now()->timestamp;
        $filePath = "reports/{$fileId}.xlsx";

        IOFactory::createWriter($sheet->getParent(), 'Xlsx')->save(storage_path("app/{$filePath}"));

        $title = "{$this->startDate} - {$this->endDate} Asistencias de los usuarios del sistema";
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
