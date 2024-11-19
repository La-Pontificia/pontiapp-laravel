<?php

namespace App\Jobs;

use App\Models\AssistEvent;
use App\Models\Report;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event_id;
    public $career;
    public $period;
    public $institution;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($event_id, $career, $period, $institution, $userId)
    {
        $this->event_id = $event_id;
        $this->career = $career;
        $this->period = $period;
        $this->institution = $institution;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $match = AssistEvent::orderBy('created_at', 'desc');

        $user = User::find($this->userId);
        if ($this->event_id) $match->where('event_id', $this->event_id);
        if ($this->career) $match->where('career', $this->career);
        if ($this->period) $match->where('period', $this->period);
        if ($this->institution) $match->where('institution', $this->institution);

        $assists = $match->get();

        $spreadsheet = IOFactory::load(public_path('templates/assist-events.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $r = 4;

        foreach ($assists as $assist) {
            $worksheet->setCellValue('B' . $r, $r - 3);
            $worksheet->setCellValue('C' . $r, $assist->document_id);
            $worksheet->setCellValue('D' . $r, $assist->first_surname . ' ' . $assist->second_surname . ', ' . $assist->first_name);
            $worksheet->setCellValue('E' . $r, $assist->sex);
            $worksheet->setCellValue('F' . $r, $assist->career);
            $worksheet->setCellValue('G' . $r, $assist->period);
            $worksheet->setCellValue('H' . $r, $assist->institution);
            $worksheet->setCellValue('I' . $r, $assist->email);
            $worksheet->setCellValue('J' . $r, $assist->event->name);
            $worksheet->setCellValue('K' . $r, $assist->created_at->format('d/m/Y'));
            $worksheet->getStyle('K' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('L' . $r, $assist->created_at->format('H:i:s'));
            $worksheet->getStyle('L' . $r)->getNumberFormat()->setFormatCode('HH:MM:SS');
            $r++;
        }

        foreach (range('B', 'L') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $fileName = now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $email = $user->email;
        Mail::raw('Hola, el reporte de Asistencias a eventos ya está disponible. Has click aquí: ' . $downloadLink, function ($message) use ($email) {
            $message->to($email)
                ->subject('Reporte de Asistencias a Eventos Generado');
        });

        Report::create([
            'title' => 'Asistencias a eventos',
            'file_url' => $filePath,
            'download_link' => $downloadLink,
            'ext' => 'xlsx',
            'generated_by' => $this->userId,
        ]);
    }
}
