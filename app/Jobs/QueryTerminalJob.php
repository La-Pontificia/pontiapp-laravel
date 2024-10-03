<?php

namespace App\Jobs;

use App\Models\AssistTerminal;
use App\Models\Attendance;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class QueryTerminalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $query;
    public $terminalId;
    public $startDate;
    public $endDate;
    public $result;
    /**
     * Create a new job instance.
     */
    public function __construct($query, $startDate, $endDate, $terminalId)
    {
        $this->query = $query;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->terminalId = $terminalId;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $terminal = AssistTerminal::find($this->terminalId);


        $attendanceQuery = DB::connection($terminal->database_name)
            ->table('iclock_transaction as it')
            ->join('personnel_employee as pe', 'it.emp_code', '=', 'pe.emp_code')
            ->select('it.id', 'it.punch_time', 'it.upload_time', 'pe.emp_code', 'pe.first_name', 'pe.last_name')
            ->whereBetween(DB::raw('CAST(it.punch_time AS DATE)'), [$this->startDate, $this->endDate])
            ->orderBy('it.punch_time', 'desc')
            ->limit(50);

        if (!empty($this->query)) {
            $attendanceQuery->where(function ($q) {
                $q->where('pe.first_name', 'like', '%' . $this->query . '%')
                    ->orWhere('pe.last_name', 'like', '%' . $this->query . '%')
                    ->orWhere('pe.emp_code', 'like', '%' . $this->query . '%');
            });
        }

        // Obtener los registros
        $matched = $attendanceQuery->get();

        // Procesar los datos y almacenarlos en $this->result
        $this->result = $matched->map(function ($item) use ($terminal) {
            $punchTime = Carbon::parse($item->punch_time);
            return [
                'id' => $item->id,
                'date' => $punchTime->format('d-m-Y'),
                'day' => $punchTime->isoFormat('dddd'),
                'employee_code' => $item->emp_code,
                'employee_name' => $item->first_name . ' ' . $item->last_name,
                'time' => $punchTime->format('H:i:s'),
                'sync_date' => Carbon::parse($item->upload_time)->format('d-m-Y H:i:s'),
                'terminal_name' => $terminal->name,
                'terminal_database' => $terminal->database_name,
            ];
        });
    }
}
