<?php

namespace App\Jobs;

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
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsWithoutCalculating implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $query;
    public $terminalsIds;
    public $startDate;
    public $endDate;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($query, $terminalsIds, $startDate, $endDate, $userId)
    {
        $this->query = $query;
        $this->terminalsIds = $terminalsIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $terminals = AssistTerminal::whereIn('id', $this->terminalsIds)->get();

        $assists = collect();

        foreach ($terminals as $terminal) {

            $attendanceQuery = DB::connection($terminal->database_name)
                ->table('iclock_transaction as it')
                ->join('personnel_employee as pe', 'it.emp_code', '=', 'pe.emp_code')
                ->select('it.id', 'it.punch_time', 'it.upload_time', 'pe.emp_code', 'pe.first_name', 'pe.last_name')
                ->whereBetween(DB::raw('CAST(it.punch_time AS DATE)'), [$this->startDate, $this->endDate])
                ->orderBy('it.punch_time', 'desc');

            if (!empty($this->query)) {
                $attendanceQuery->where(function ($q) {
                    $q->where('pe.first_name', 'like', '%' . $this->query . '%')
                        ->orWhere('pe.last_name', 'like', '%' . $this->query . '%')
                        ->orWhere('pe.emp_code', 'like', '%' . $this->query . '%');
                });
            }

            $matched = $attendanceQuery->get();

            $assists = $assists->merge($matched->map(function ($item) use ($terminal) {
                $punchTime = Carbon::parse($item->punch_time);
                return [
                    'id' => $item->id,
                    'date' => $punchTime->format('d-m-Y'),
                    'day' => $punchTime->isoFormat('dddd'),
                    'employee_code' => $item->emp_code,
                    'employee_name' => $item->first_name . ' ' . $item->last_name,
                    'time' => $punchTime->format('H:i:s'),
                    'sync_date' => Carbon::parse($item->upload_time)->format('d-m-Y H:i:s'),
                    'terminal' => $terminal,
                ];
            }));
        }

        // Agrupar los datos primero por terminal, luego por DNI y luego por fecha
        $groupedAssists = $assists->groupBy(function ($assist) {
            return $assist['terminal']->id; // Agrupar por terminal
        })->map(function ($group) {
            return $group->groupBy('employee_code')->map(function ($subGroup) {
                return $subGroup->groupBy('date');
            });
        });

        // Cargar la plantilla de Excel
        $spreadsheet = IOFactory::load(public_path('templates/without-calculating.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        // Iniciar en la fila 4 para llenar los datos
        $rr = 4;

        foreach ($groupedAssists as $terminalId => $employees) {

            foreach ($employees as $employeeCode => $dates) {
                foreach ($dates as $date => $assists) {
                    foreach ($assists as $assist) {
                        $worksheet->setCellValue('B' . $rr, $rr - 3); // Número de asistencia
                        $worksheet->setCellValue('C' . $rr, $assist['terminal']->name);
                        $worksheet->setCellValue('D' . $rr, $assist['employee_code'] ?? "");
                        $worksheet->setCellValue('E' . $rr, $assist['employee_name'] ?? "");
                        $worksheet->setCellValue('F' . $rr, \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($assist['date']));
                        $worksheet->getStyle('F' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $worksheet->setCellValue('G' . $rr, $assist['day']);
                        $worksheet->setCellValue('H' . $rr, $assist['time']);
                        $worksheet->getStyle('H' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('I' . $rr, $assist['sync_date']);
                        $rr++;
                    }
                }
            }
        }

        // Ajustar el ancho de las columnas
        foreach (range('B', 'I') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Guardar el archivo Excel
        $fileName = now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $email = User::find($this->userId)->email;
        Mail::raw('Hola, el reporte de Asistencias ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, function ($message) use ($email) {
            $message->to($email)
                ->subject('Reporte de Asistencias Generado');
        });


        Report::create([
            'title' => 'Asistencias sin calcular',
            'file_url' => $filePath,
            'download_link' => $downloadLink,
            'ext' => 'xlsx',
            'generated_by' => $this->userId,
        ]);
    }
}
