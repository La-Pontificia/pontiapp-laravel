<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\Event;
use App\Models\EventRecord as EventRecordModel;
use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EventRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(
        public $eventId,
        public $businessUnitId,
        public $userId
    ) {}


    public function handle(): void
    {

        $match = EventRecordModel::orderBy('created_at', 'desc');

        if ($this->eventId) $match->where('eventId', $this->eventId);
        if ($this->businessUnitId) $match->where('businessUnitId', $this->businessUnitId);

        $records = $match->get();

        $spreadsheet = IOFactory::load(public_path('templates/record-events.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();

        $r = 2;

        foreach ($records as $record) {
            $sheet->setCellValue('A' . $r, $r - 1);
            $sheet->setCellValue('B' . $r, $record->documentId);
            $sheet->setCellValue('C' . $r, $record->fullName ? $record->fullName : $record->lastNames . ', ' . $record->firstNames);
            $sheet->setCellValue('D' . $r, $record->gender);
            $sheet->setCellValue('E' . $r, $record->career);
            $sheet->setCellValue('F' . $r, $record->period);
            $sheet->setCellValue('G' . $r, $record->businessUnit->name);
            $sheet->setCellValue('H' . $r, $record->email);
            $sheet->setCellValue('I' . $r, $record->event->name);
            $sheet->setCellValue('J' . $r, $record->created_at->format('d/m/Y'));
            $sheet->getStyle('J' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $sheet->setCellValue('K' . $r, $record->created_at->isoFormat('HH:mm:ss'));
            $sheet->getStyle('K' . $r)->getNumberFormat()->setFormatCode('HH:MM:SS');
            $r++;
        }

        $event = Event::find($this->eventId);

        Storage::makeDirectory('reports');
        $fileId = now()->timestamp;
        $filePath = "reports/{$fileId}.xlsx";

        IOFactory::createWriter($sheet->getParent(), 'Xlsx')->save(storage_path("app/{$filePath}"));

        $title = 'Asistentes del evento (' . $event?->name . ')';
        $report = Report::create([
            'fileId' => $fileId,
            'title' => $title,
            'ext' => 'xlsx',
            'creatorId' => $this->userId,
            'module' => 'events',
        ]);

        $link = config('app.download_url') . "/reports/{$report->id}";
        ReportSendEmail::dispatch($report->title, 'eventos', 'las asistencias al evento', $link, $this->userId);
    }
}
