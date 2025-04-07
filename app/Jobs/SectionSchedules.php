<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\Academic\Period;
use App\Models\Academic\Program;
use App\Models\Academic\SectionCourseSchedule;
use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SectionSchedules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $programId;
    public $periodId;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($programId,  $periodId, $userId)
    {
        $this->userId = $userId;
        $this->programId = $programId;
        $this->periodId = $periodId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $match = SectionCourseSchedule::orderBy('created_at', 'desc');
        $user = User::find($this->userId);

        $schedules = $match->whereHas('sectionCourse', function ($query) {
            $query->whereHas('section', function ($query) {
                $query->where('periodId', $this->periodId)
                    ->where('programId', $this->programId);
            });
        })->get();

        $spreadsheet = IOFactory::load(public_path('templates/section_schedules.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $r = 2;


        foreach ($schedules as $schedule) {

            $teacherNames = $schedule->sectionCourse?->teacher
                ? strtoupper($schedule->sectionCourse?->teacher?->lastNames) . ', ' . strtoupper($schedule->sectionCourse?->teacher?->firstNames)
                : '';
            $teacherDocumentId = $schedule->sectionCourse?->teacher
                ? $schedule->sectionCourse?->teacher?->documentId
                : '';

            $worksheet->setCellValue('A' . $r, $schedule->sectionCourse?->section?->period?->name);
            $worksheet->setCellValue('B' . $r, $schedule->startDate?->format('d/m/Y'));
            $worksheet->getStyle('B' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('C' . $r, $schedule->endDate?->format('d/m/Y'));
            $worksheet->getStyle('C' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('D' . $r, $schedule->sectionCourse?->section?->period?->businessUnit?->acronym);
            $worksheet->setCellValue('E' . $r, $schedule->sectionCourse?->section?->program?->name);
            $worksheet->setCellValue('F' . $r, $schedule->sectionCourse?->section?->cycle?->code);
            $worksheet->setCellValue('G' . $r, $schedule->sectionCourse?->section?->code);
            $worksheet->setCellValue('H' . $r, $schedule->sectionCourse?->planCourse?->name);
            $worksheet->setCellValue('I' . $r, $schedule->sectionCourse?->planCourse?->course?->code);
            $worksheet->setCellValue('J' . $r, $schedule->days);
            $worksheet->setCellValue('K' . $r, $schedule->startTime->format('H:i'));
            $worksheet->getStyle('K' . $r)->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue('L' . $r, $schedule->endTime->format('H:i'));
            $worksheet->getStyle('L' . $r)->getNumberFormat()->setFormatCode('HH:MM');
            $worksheet->setCellValue('M' . $r, $schedule->classroom?->code);
            $worksheet->setCellValue('N' . $r, $schedule->classroom?->type);
            $worksheet->setCellValue('O' . $r, $teacherNames);
            $worksheet->setCellValue('P' . $r, $teacherDocumentId);
            $r++;
        }

        $fileName = 'section_schedules' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);
        $email = $user->email;

        $period = Period::find($this->periodId);
        $program = Program::find($this->programId);

        SendEmail::dispatch('Reporte de horarios (' . $program?->name . ' - ' . $period?->name . ')', 'Hola, reporte disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, $email);

        event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de horarios ya esta listo.', [
            'Descargar' => $downloadLink,
            'Ver' => '/m/academic/report-files',
        ]));

        Report::create([
            'title' => 'Horarios (' . $program?->name . ' - ' . $period?->name . ')',
            'fileUrl' => $filePath,
            'downloadLink' => $downloadLink,
            'ext' => 'xlsx',
            'creatorId' => $user->id,
            'module' => 'academic',
            'created_at' => now(),
        ]);
    }
}
