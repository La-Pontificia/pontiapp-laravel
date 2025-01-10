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
use PhpOffice\PhpSpreadsheet\IOFactory;

class EventRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $eventId;
    public $businessUnitId;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($eventId,  $businessUnitId, $userId)
    {
        $this->eventId = $eventId;
        $this->businessUnitId = $businessUnitId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $match = EventRecordModel::orderBy('created_at', 'desc');
        $user = User::find($this->userId);

        if ($this->eventId) $match->where('eventId', $this->eventId);
        if ($this->businessUnitId) $match->where('businessUnitId', $this->businessUnitId);

        $records = $match->get();

        $spreadsheet = IOFactory::load(public_path('templates/record-events.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $r = 2;

        foreach ($records as $record) {
            $worksheet->setCellValue('A' . $r, $r - 1);
            $worksheet->setCellValue('B' . $r, $record->documentId);
            $worksheet->setCellValue('C' . $r, $record->fullName ? $record->fullName : $record->lastNames . ', ' . $record->firstNames);
            $worksheet->setCellValue('D' . $r, $record->gender);
            $worksheet->setCellValue('E' . $r, $record->career);
            $worksheet->setCellValue('F' . $r, $record->period);
            $worksheet->setCellValue('G' . $r, $record->business->name);
            $worksheet->setCellValue('H' . $r, $record->email);
            $worksheet->setCellValue('I' . $r, $record->event->name);
            $worksheet->setCellValue('J' . $r, $record->created_at->format('d/m/Y'));
            $worksheet->getStyle('J' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('K' . $r, $record->created_at->isoFormat('HH:mm:ss'));
            $worksheet->getStyle('K' . $r)->getNumberFormat()->setFormatCode('HH:MM:SS');
            $r++;
        }

        foreach (range('A', 'K') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }


        $fileName = 'events_records_' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $user = User::find($this->userId);
        $email = $user->email;

        $event = Event::find($this->eventId);

        SendEmail::dispatch('Reporte de eventos finalizado.', 'Hola, el reporte de eventos ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, $email);

        event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de eventos ya esta listo.', [
            'Descargar' => $downloadLink,
            'Ver' => '/m/events/report-files',
        ]));

        Report::create([
            'title' => 'Registros de eventos (' . $event?->name . ')',
            'fileUrl' => $filePath,
            'downloadLink' => $downloadLink,
            'ext' => 'xlsx',
            'generatedBy' => $user->id,
            'module' => 'events-records',
            'created_at' => now(),
        ]);
    }
}
