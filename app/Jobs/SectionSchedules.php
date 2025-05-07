<?php

namespace App\Jobs;

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
    public $periodIds;
    public $programIds;

    /**
     * Create a new job instance.
     */
    public function __construct($programId,  $periodId, $periodIds, $programIds, $userId)
    {
        $this->userId = $userId;
        $this->programId = $programId;
        $this->periodId = $periodId;
        $this->periodIds = $periodIds;
        $this->programIds = $programIds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $match = SectionCourseSchedule::orderBy('created_at', 'desc');
        $user = User::find($this->userId);

        if ($this->periodId) {
            $match->whereHas('sectionCourse.section', function ($query) {
                $query->where('periodId', $this->periodId);
            });
        }

        if ($this->programId) {
            $match->whereHas('sectionCourse.section', function ($query) {
                $query->where('programId', $this->programId);
            });
        }

        if ($this->periodIds) {
            $match->whereHas('sectionCourse.section', function ($query) {
                $query->whereIn('periodId', $this->periodIds);
            });
        }

        if ($this->programIds) {
            $match->whereHas('sectionCourse.section', function ($query) {
                $query->whereIn('programId', $this->programIds);
            });
        }

        $schedules = $match->get();

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

            $teacherEmail = $schedule->sectionCourse?->teacher
                ? $schedule->sectionCourse?->teacher?->email
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
            $worksheet->setCellValue('Q' . $r, $teacherEmail);

            $r++;
        }

        $fileName = 'section_schedules' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);

        $period = Period::find($this->periodId);
        $program = Program::find($this->programId);

        $displayNameFile = 'Horarios ';

        if ($this->periodId && $this->programId) {
            $displayNameFile .= '(periodo: ' . $period?->name . ', ' . $program?->acronym . ')';
        }

        if ($this->periodIds) {
            $periods = Period::whereIn('id', $this->periodIds)->get();
            $periodNames = $periods->pluck('name')->implode(', ');
            $displayNameFile .= '(periodos: ' . $periodNames . ') ';
        }

        if ($this->programIds) {
            $programs = Program::whereIn('id', $this->programIds)->get();
            $programAcronyms = $programs->pluck('acronym')->implode(', ');
            $displayNameFile .= '(' . $period?->name . ', programas: ' .  $programAcronyms . ')';
        }

        $report = Report::create([
            'title' => '' . $displayNameFile . '',
            'fileUrl' => $filePath,
            'ext' => 'xlsx',
            'creatorId' => $user->id,
            'module' => 'academic',
            'created_at' => now(),
        ]);

        $downloadLink = config('app.url') . '/api/tools/downloadReportFile/' . $report->id;

        ReportSendEmail::dispatch($report->title, 'académico', 'los horarios', $downloadLink, $this->userId);
    }
}
