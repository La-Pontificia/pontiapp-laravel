<?php

namespace App\Jobs;

use App\Events\UserNotice;
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
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Assists implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $q;
    public $terminalIds;
    public $startDate;
    public $endDate;
    public $jobId;
    public $areaId;
    public $userId;

    public function __construct($q, $terminalIds, $startDate, $endDate, $jobId, $areaId, $userId)
    {
        $this->q = $q;
        $this->terminalIds = $terminalIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->jobId = $jobId;
        $this->areaId = $areaId;
        $this->userId = $userId;
    }

    public function handle(): void
    {

        $queryUsers = User::orderBy('created_at');
        $areaId = $this->areaId;
        $jobId = $this->jobId;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $q = $this->q;
        $user = User::find($this->userId);

        if ($areaId) {
            $queryUsers->whereHas('role', function ($query) use ($areaId) {
                $query->whereHas('department', function ($query) use ($areaId) {
                    $query->where('areaId', $areaId);
                });
            });
        }

        if ($jobId) {
            $queryUsers->whereHas('role', function ($query) use ($jobId) {
                $query->where('jobId', $jobId);
            });
        }

        if ($q) {
            $queryUsers->where(function ($query) use ($q) {
                $query->where('documentId', 'LIKE', "%$q%")
                    ->orWhere('firstNames', 'LIKE', "%$q%")
                    ->orWhere('lastNames', 'LIKE', "%$q%")
                    ->orWhere('fullName', 'LIKE', "%$q%")
                    ->orWhere('displayName', 'LIKE', "%$q%");
            });
        }

        $terminals = AssistTerminal::whereIn('id', $this->terminalIds)->get();

        $queryUsers->whereHas('schedules', function ($query) use ($startDate, $endDate) {
            $query->whereIn('assistTerminalId', $this->terminalIds)
                ->where('startDate', '<=', $startDate)
                ->where(function ($query) use ($endDate) {
                    $query->where('endDate', '>=', $endDate)
                        ->orWhereNull('endDate');
                });
        });

        $users = $queryUsers->with('schedules')->get();

        if ($users->isEmpty()) {
            event(new UserNotice($user->id, "Reporte no realizado.", 'No se encontraron usuarios con horarios en el rango de fechas seleccionado.', [
                'Ver' => '/m/assists/report-files',
            ]));
        } else {
            $plainStartDate = $startDate . 'T00:00:00.000';
            $plainEndDate = $endDate . 'T23:59:59.999';

            $userOnlyDocumentIds = $users->pluck('documentId')->toArray();

            foreach ($terminals as $terminal) {
                $query = "
                    SELECT 
                        it.id AS id,
                        it.punch_time AS datetime, 
                        pe.emp_code AS documentId, 
                        '$terminal->id' AS terminalId
                        FROM 
                            [$terminal->database].dbo.iclock_transaction AS it
                        JOIN 
                            [$terminal->database].dbo.personnel_employee AS pe ON it.emp_code = pe.emp_code
                        WHERE 
                            it.punch_time >= '$plainStartDate' 
                            AND it.punch_time <= '$plainEndDate'
                            AND pe.emp_code IN (" . implode(',', $userOnlyDocumentIds) . ")
                    ";
                $unionQueries[] = $query;
            }

            $finalSql = implode(" UNION ALL ", $unionQueries) . " ORDER BY datetime DESC";
            $results = collect(DB::connection('sqlsrv_dynamic')->select($finalSql));


            $schedules = $users->pluck('schedules')->flatten();

            Log::info('Schedules: ' . $schedules);


            $firstAssistsBySchedules = collect([]);

            foreach ($schedules as $schedule) {
                $start = $startDate < $schedule->startDate ? Carbon::parse($schedule->startDate) : Carbon::parse($startDate);
                $end = $schedule->endDate ? ($endDate > $schedule->endDate ? Carbon::parse($schedule->endDate) : Carbon::parse($endDate)) : Carbon::parse($endDate);

                $days = collect($schedule->days);

                $assists = $results->filter(function ($result) use ($schedule) {
                    return $result->documentId == $schedule->user->documentId && $result->terminalId == $schedule->assistTerminalId;
                });

                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

                    // Si el día de la semana está en los días de la semana del horario
                    if ($days->contains($date->dayOfWeekIso)) {
                        $from = Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day);
                        $to = Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day);

                        $entryRangeStart = $from->copy()->subHour(2);
                        $entryRangeEnd = $from->copy()->addHour(2);

                        $exitRangeStart = $to->copy()->subHour(2);
                        $exitRangeEnd = $to->copy()->addHour(2);

                        $dailyAssists = $assists->filter(function ($assist) use ($date) {
                            return Carbon::parse($assist->datetime)->isSameDay($date);
                        });


                        // Buscar entrada más cercana al rango
                        $entry = $dailyAssists->filter(function ($assist) use ($entryRangeStart, $entryRangeEnd) {
                            $datetime = Carbon::parse($assist->datetime);
                            return $datetime->between($entryRangeStart, $entryRangeEnd);
                        })->sortBy(function ($assist) use ($from) {
                            return abs(Carbon::parse($assist->datetime)->diffInSeconds($from));
                        })->first();

                        if ($entry) {
                            $assists = $assists->reject(function ($assist) use ($entry) {
                                return $assist->id === $entry->id;
                            });
                            $results = $results->reject(function ($result) use ($entry) {
                                return $result->id === $entry->id;
                            });
                            $dailyAssists = $dailyAssists->reject(function ($assist) use ($entry) {
                                return $assist->id === $entry->id;
                            });
                        }

                        // Buscar salida más cercana al rango
                        $exit = $dailyAssists->filter(function ($assist) use ($exitRangeStart, $exitRangeEnd) {
                            $datetime = Carbon::parse($assist->datetime);
                            return $datetime->between($exitRangeStart, $exitRangeEnd);
                        })->sortBy(function ($assist) use ($to) {
                            return abs(Carbon::parse($assist->datetime)->diffInSeconds($to));
                        })->first();

                        if ($exit) {
                            $assists = $assists->reject(function ($assist) use ($exit) {
                                return $assist->id === $exit->id;
                            });
                            $results = $results->reject(function ($result) use ($exit) {
                                return $result->id === $exit->id;
                            });

                            $dailyAssists = $dailyAssists->reject(function ($assist) use ($exit) {
                                return $assist->id === $exit->id;
                            });
                        }


                        $firstAssistsBySchedules[] = [
                            'date' => $date->copy(),
                            'from' => $from,
                            'to' => $to,
                            'user' => $schedule->user,
                            'terminal' => $terminals->where('id', $schedule->assistTerminalId)->first(),
                            'markedIn' => $entry ? $entry->datetime : null,
                            'markedOut' => $exit ? $exit->datetime : null,
                        ];
                    }
                }
            }

            $firstAssistsBySchedules = collect($firstAssistsBySchedules)->sortByDesc('date')->values();

            $restAssists = $results->map(function ($assist) use ($terminals) {
                $assist->terminal = $terminals->where('id', $assist->terminalId)->first();
                $assist->user = User::where('documentId', $assist->documentId)->first();
                return $assist;
            });

            $groupedAssists = $firstAssistsBySchedules->groupBy(function ($assist) {
                return $assist['terminal']->id;
            })->map(function ($group) {
                return $group->groupBy(function ($assist) {
                    return $assist['user']->documentId;
                })->map(function ($subGroup) {
                    return $subGroup->groupBy(function ($assist) {
                        return $assist['date']->format('Y-m-d');
                    });
                });
            });

            $spreadsheet = IOFactory::load(public_path('templates/assists.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet();

            $rr = 4;
            foreach ($groupedAssists as $terminalId => $employees) {
                foreach ($employees as $documentId => $dates) {
                    foreach ($dates as $date => $assists) {
                        foreach ($assists as $assist) {

                            $arriveLate = Carbon::parse($assist['from'])->diffInMinutes(Carbon::parse($assist['markedIn']), false) > 0;
                            $outBefore = Carbon::parse($assist['markedOut'])->lt(Carbon::parse($assist['to']));

                            $worksheet->setCellValue('B' . $rr, $rr - 3);
                            $worksheet->setCellValue('C' . $rr, $assist['terminal']?->name ?? "");
                            $worksheet->setCellValue('D' . $rr, $assist['user']?->documentId);
                            $worksheet->setCellValue('E' . $rr, $assist['user']?->lastNames . ', ' . $assist['user']?->firstNames);
                            $worksheet->setCellValue('F' . $rr, $assist['user']?->role?->name ?? "");
                            $worksheet->setCellValue('G' . $rr, $assist['user']?->role?->department?->area?->name ?? "");
                            $worksheet->setCellValue('H' . $rr, Carbon::parse($assist['date'])->format('d/m/Y'));
                            $worksheet->setCellValue('I' . $rr, Carbon::parse($assist['date'])->isoFormat('dddd'));
                            $worksheet->getStyle('I' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');

                            $worksheet->setCellValue('J' . $rr, Carbon::parse($assist['from'])->format('H:i'));
                            $worksheet->getStyle('J' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                            $worksheet->setCellValue('K' . $rr, Carbon::parse($assist['to'])->format('H:i'));
                            $worksheet->getStyle('K' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                            $worksheet->setCellValue('L' . $rr, $assist['markedIn'] ? Carbon::parse($assist['markedIn'])->format('H:i:s') : "");
                            $worksheet->getStyle('L' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                            if ($arriveLate) {
                                $worksheet->getStyle('L' . $rr)->getFont()->getColor()->setARGB('ff9114');
                            } else {
                                $worksheet->getStyle('L' . $rr)->getFont()->getColor()->setARGB('006f39');
                            }

                            $worksheet->setCellValue('M' . $rr, $assist['markedOut'] ? Carbon::parse($assist['markedOut'])->format('H:i:s') : "");
                            $worksheet->getStyle('M' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                            if ($outBefore) {
                                $worksheet->getStyle('M' . $rr)->getFont()->getColor()->setARGB('ff9114');
                            } else {
                                $worksheet->getStyle('M' . $rr)->getFont()->getColor()->setARGB('006f39');
                            }

                            $rr++;
                        }
                    }
                }
            }

            $rr = $rr + 5;
            $rrr = 0;
            foreach ($restAssists as $assist) {
                $worksheet->setCellValue('B' . $rr, $rrr + 1);
                $worksheet->setCellValue('C' . $rr, $assist->terminal?->name ?? "");
                $worksheet->setCellValue('D' . $rr, $assist->documentId);
                $worksheet->setCellValue('E' . $rr, $assist->user?->lastNames . ', ' . $assist->user?->firstNames);
                $worksheet->setCellValue('F' . $rr, $assist->user?->role?->name ?? "");
                $worksheet->setCellValue('G' . $rr, $assist->user?->role?->department?->area?->name ?? "");
                $worksheet->setCellValue('H' . $rr, Carbon::parse($assist->datetime)->format('d/m/Y'));
                $worksheet->setCellValue('I' . $rr, Carbon::parse($assist->datetime)->isoFormat('dddd'));
                $worksheet->getStyle('I' . $rr)->getNumberFormat()->setFormatCode('DD/MM/YYYY');

                $worksheet->setCellValue('N' . $rr, Carbon::parse($assist->datetime)->format('H:i'));
                $worksheet->getStyle('N' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                $rr++;
                $rrr++;
            }

            foreach (range('B', 'N') as $columnID) {
                $worksheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            $fileName = 'assists_' . now()->timestamp . '.xlsx';
            $filePath = 'files/reports/' . $fileName;
            $downloadLink = asset($filePath);


            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(public_path($filePath));

            $email = $user->email;

            SendEmail::dispatch('Reporte de asistencias finalizado.', 'Hola, el reporte de asistencias con horarios ya está disponible. Puedes descargarlo desde el siguiente enlace: ' . $downloadLink, $email);

            event(new UserNotice($user->id, "Reporte finalizado.", 'EL reporte de asistencias con horarios ya esta listo.', [
                'Descargar' => $downloadLink,
                'Ver' => '/m/assists/report-files',
            ]));

            Report::create([
                'title' => 'Registros de asistencias con horarios.',
                'fileUrl' => $filePath,
                'downloadLink' => $downloadLink,
                'ext' => 'xlsx',
                'generatedBy' => $user->id,
                'module' => 'assists',
            ]);
        }
    }
}
