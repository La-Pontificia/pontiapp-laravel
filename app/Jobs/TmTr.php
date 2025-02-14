<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\Report;
use App\Models\RmTTracking;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TmTr implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $q;
    public $section;
    public $period;
    public $academicProgram;
    public $startDate;
    public $endDate;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($q, $section, $period, $academicProgram, $startDate, $endDate, $userId)
    {
        $this->q = $q;
        $this->section = $section;
        $this->period = $period;
        $this->academicProgram = $academicProgram;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $match = RmTTracking::orderBy('created_at', 'desc');
        if ($this->section) $match->where('section', $this->section);
        if ($this->period) $match->where('period', $this->period);
        if ($this->academicProgram) $match->where('academicProgram', $this->academicProgram);
        if ($this->startDate) $match->where('date', '>=', $this->startDate);
        if ($this->endDate) $match->where('date', '<=', $this->endDate);

        if ($this->q) $match->where('teacherFullName', 'like', "%$this->q%")
            ->orWhere('teacherDocumentId', 'like', "%$this->q%")
            ->orWhere('section', 'like', "%$this->q%")
            ->orWhere('period', 'like', "%$this->q%");

        $data = $match->get();

        $spreadsheet = IOFactory::load(public_path('templates/tt.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $rr = 5;
        foreach ($data as $item) {
            $worksheet->setCellValue('A' . $rr, $rr - 4);
            $worksheet->setCellValue('B' . $rr, $item->teacherDocumentId);
            $worksheet->setCellValue('C' . $rr, $item->teacherFullName);
            $worksheet->setCellValue('D' . $rr, $item->period);
            $worksheet->setCellValue('E' . $rr, $item->cycle);
            $worksheet->setCellValue('F' . $rr, $item->section);
            $worksheet->setCellValue('G' . $rr, $item->businessUnit->acronym);
            $worksheet->setCellValue('H' . $rr, $item->area);
            $worksheet->setCellValue('H' . $rr, $item->area);
            $worksheet->setCellValue('I' . $rr, $item->academicProgram);
            $worksheet->setCellValue('J' . $rr, $item->course);
            $worksheet->setCellValue('K' . $rr, $item->date->format('Y-m-d'));
            $worksheet->setCellValue('L' . $rr, $item->evaluationNumber);
            $worksheet->setCellValue('M' . $rr, $item->trackingTime->format('H:i:s'));
            $worksheet->setCellValue('N' . $rr, $item->er1a . '%');
            $worksheet->setCellValue('O' . $rr, $item->er1b . '%');
            $worksheet->setCellValue('P' . $rr, $item->er1Obtained . '%');
            $worksheet->setCellValue('Q' . $rr, $item->er1Qualification);
            $worksheet->setCellValue('R' . $rr, $item->er2a1 . '%');
            $worksheet->setCellValue('S' . $rr, $item->er2a2 . '%');
            $worksheet->setCellValue('T' . $rr, $item->er2aObtained . '%');
            $worksheet->setCellValue('U' . $rr, $item->er2b1 . '%');
            $worksheet->setCellValue('V' . $rr, $item->er2b2 . '%');
            $worksheet->setCellValue('W' . $rr, $item->er2bObtained . '%');
            $worksheet->setCellValue('X' . $rr, $item->er2Total . '%');
            $worksheet->setCellValue('Y' . $rr, $item->er2FinalGrade);
            $worksheet->setCellValue('Z' . $rr, $item->er2Qualification);
            $worksheet->setCellValue('AA' . $rr, $item->aditional1);
            $worksheet->setCellValue('AB' . $rr, $item->aditional2);
            $worksheet->setCellValue('AC' . $rr, $item->aditional3);
            $rr++;
        }

        $fileName = 'rm_' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);

        ReportSendEmail::dispatch('Evaluaciones de docentes disponible.', 'gestión de recursos', 'evaluación de docentes', $downloadLink, $user->id);

        event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de evaluaciones y seguimiento de docentes ya esta diponible.', [
            'Descargar' => $downloadLink,
            'Ver' => '/m/rm/report-files',
        ]));

        Report::create([
            'title' => 'Seguimiento y evaluaciones de docentes.',
            'fileUrl' => $filePath,
            'downloadLink' => $downloadLink,
            'ext' => 'xlsx',
            'creatorId' => $user->id,
            'module' => 'rm',
        ]);
    }
}
