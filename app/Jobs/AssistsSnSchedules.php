<?php

namespace App\Jobs;

use App\Models\AssistTerminal;
use App\Models\Attendance;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssistsSnSchedules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $query;
    public $terminalsIds;
    public $startDate;
    public $endDate;
    public $customEmail;
    public $userId;


    /**
     * Create a new job instance.
     */
    public function __construct($query, $terminalsIds, $startDate, $endDate, $customEmail, $userId)
    {
        $this->query = $query;
        $this->terminalsIds = $terminalsIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->customEmail = $customEmail;
        $this->userId = $userId;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $terminals = AssistTerminal::whereIn('id', $this->terminalsIds)->get();
        $users = null;

        if ($this->query) {
            User::where('first_name', 'like', '%' . $this->query . '%')
                ->orWhere('last_name', 'like', '%' . $this->query . '%')
                ->orWhere('dni', 'like', '%' . $this->query . '%')
                ->get();
        } else {
            $users = User::all();
        }

        $assists = Collect([]);

        foreach ($terminals as $terminal) {

            $userDnis = $users->pluck('dni')->toArray();

            $match = (new Attendance())
                ->setConnection($terminal->database_name)
                ->whereBetween(DB::raw('CAST(punch_time AS DATE)'), [$this->startDate, $this->endDate])
                ->whereIn('emp_code', $userDnis)
                ->orderBy('punch_time', 'desc');

            $matched = [];

            $matched = $match->get();

            $assists = $assists->merge($matched->map(function ($item) use ($terminal) {
                $punchTime = Carbon::parse($item->punch_time);
                $user = User::where('dni', $item->emp_code)->first();

                if (!$user) {
                    return null;
                }

                return [
                    'id' => $item->id,
                    'user' =>  $user,
                    'employee_code' => $user->dni,
                    'date' => $punchTime->format('d-m-Y'),
                    'day' => $punchTime->isoFormat('dddd'),
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
        $spreadsheet = IOFactory::load(public_path('templates/assists-sn-schedules.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        // Iniciar en la fila 4 para llenar los datos
        $rr = 4;

        foreach ($groupedAssists as $terminalId => $employees) {

            foreach ($employees as $employeeCode => $dates) {
                foreach ($dates as $date => $assists) {
                    foreach ($assists as $assist) {
                        $worksheet->setCellValue('B' . $rr, $rr - 3); // Número de asistencia
                        $worksheet->setCellValue('C' . $rr, $assist['terminal']->name);
                        $worksheet->setCellValue('D' . $rr, $assist['user']->dni ?? "");
                        $worksheet->setCellValue('E' . $rr, $assist['user']->first_name . ' ' . $assist['user']->last_name ?? "");
                        $worksheet->setCellValue('F' . $rr, $assist['user']->role_position->name ?? "");
                        $worksheet->setCellValue('G' . $rr, $assist['user']->role_position->job_position->name ?? "");

                        $worksheet->setCellValue('H' . $rr, \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($assist['date']));
                        $worksheet->getStyle('H' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
                        $worksheet->setCellValue('I' . $rr, $assist['day']);
                        $worksheet->setCellValue('J' . $rr, $assist['time']);
                        $worksheet->getStyle('J' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('K' . $rr, $assist['sync_date']);
                        $rr++;
                    }
                }
            }
        }

        // Ajustar el ancho de las columnas
        foreach (range('B', 'K') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Guardar el archivo Excel
        $fileName = now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $downloadLink = asset($filePath);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path($filePath));

        $email = $this->customEmail;
        Mail::raw('Hola, el reporte de Asistencias centralizadas ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, function ($message) use ($email) {
            $message->to($email)
                ->subject('Reporte de Asistencias Centralizadas Generado');
        });

        Report::create([
            'title' => 'Asistencias Centralizadas Sin Calcular',
            'file_url' => $filePath,
            'download_link' => $downloadLink,
            'ext' => 'xlsx',
            'generated_by' => $this->userId,
        ]);
    }
}
