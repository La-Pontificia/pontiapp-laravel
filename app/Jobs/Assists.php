<?php

namespace App\Jobs;

use App\Events\UserNotice;
use App\Models\AssistTerminal;
use App\Models\Report;
use App\Models\UserSchedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Assists implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $q,
        public $startDate,
        public $endDate,
        public $jobId,
        public $areaId,
        public $userId
    ) {}

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
                    ->orWhere('displayName', 'LIKE', "%$q%")
                    ->orWhere('email', 'LIKE', "%$q%")
                    ->orWhere('username', 'LIKE', "%$q%");
            });
        }

        $terminals = AssistTerminal::all();

        $users = $queryUsers
            ->where('status', true)
            ->whereHas('schedules')
            ->whereNotNull('documentId')
            ->get();

        if ($users->isEmpty()) {
            event(new UserNotice($user->id, "Reporte no realizado.", 'No se encontraron usuarios con horarios en el rango de fechas seleccionado.', [
                'Ver' => '/m/assists/report-files',
            ]));
        } else {
            $plainStartDate = $startDate . 'T00:00:00.000';
            $plainEndDate = $endDate . 'T23:59:59.999';

            $userOnlyDocumentIds = $users->pluck('documentId')->toArray();
            $userOnlyIds = $users->pluck('id')->toArray();

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
            $results = collect(DB::connection('sqlsrv_dynamic')->select($finalSql))->keyBy('id');

            $schedules = UserSchedule::whereIn('userId', $userOnlyIds)
                // ->where('archived', false)
                ->where('type', 'available')
                // ->where('startDate', '<=', $startDate)
                // ->where(function ($query) use ($endDate) {
                //     $query->where('endDate', '>=', $endDate)
                //         ->orWhereNull('endDate');
                // })
                ->get();

            $generatedSchedules = collect($schedules)->flatMap(function ($schedule) use ($startDate, $endDate) {
                $start = max(Carbon::parse($startDate), Carbon::parse($schedule->startDate));
                $end = $schedule->endDate ? min(Carbon::parse($endDate), Carbon::parse($schedule->endDate)) : Carbon::parse($endDate);

                return collect(Carbon::parse($start)->daysUntil($end))->filter(function ($date) use ($schedule) {
                    return collect($schedule->days)->contains($date->dayOfWeekIso);
                })->map(function ($date) use ($schedule) {
                    $from = Carbon::parse($schedule->from)->setDate($date->year, $date->month, $date->day);
                    $to = Carbon::parse($schedule->to)->setDate($date->year, $date->month, $date->day);
                    return [
                        'date' => $date,
                        'tolerence' => $schedule->tolerance,
                        'from' => $from,
                        'to' => $to,
                        'userId' => $schedule->user->id,
                        'userDocumentId' => $schedule->user->documentId
                    ];
                });
            })->values();

            $groupedSchedules = $generatedSchedules
                ->groupBy('userId')
                ->flatMap(function ($userSchedules) {
                    return $userSchedules->groupBy(fn($schedule) => $schedule['date']->format('Y-m-d'))
                        ->map(function ($dailySchedules) {
                            $firstSchedule = $dailySchedules->first();
                            $timeSlots = $dailySchedules->reduce(function ($slots, $schedule) {
                                $hour = $schedule['from']->format('H');
                                if ($hour < 12) {
                                    $slots['morningFrom'] = $schedule['from'];
                                    $slots['morningTo'] = $schedule['to'];
                                } else {
                                    $slots['afternoonFrom'] = $schedule['from'];
                                    $slots['afternoonTo'] = $schedule['to'];
                                }
                                return $slots;
                            }, [
                                'morningFrom' => null,
                                'morningTo' => null,
                                'afternoonFrom' => null,
                                'afternoonTo' => null,
                            ]);

                            return array_merge([
                                'date' => $firstSchedule['date']->format('Y-m-d'),
                                'tolerence' => $firstSchedule['tolerence'],
                                'userId' => $firstSchedule['userId'],
                                'userDocumentId' => $firstSchedule['userDocumentId']
                            ], $timeSlots, [
                                'morningMarkedIn' => null,
                                'morningMarkedOut' => null,
                                'afternoonMarkedIn' => null,
                                'afternoonMarkedOut' => null
                            ]);
                        })->values();
                })->values();

            $updatedSchedules = $groupedSchedules->map(function ($schedule) use ($results, $users) {
                $dailyResults = $results->filter(
                    fn($result) =>
                    $result->documentId === $schedule['userDocumentId'] &&
                        Carbon::parse($result->datetime)->format('Y-m-d') === $schedule['date']
                )->keyBy('id');

                $calculateAttendance = function ($timeFrom, $timeTo, $dailyResults, $results, $rangeModifier) {
                    if (!$timeFrom || !$timeTo) {
                        return [null, null];
                    }

                    $entryRangeStart = $timeFrom->copy()->sub($rangeModifier);
                    $entryRangeEnd = $timeFrom->copy()->add($rangeModifier);
                    $exitRangeStart = $timeTo->copy()->sub($rangeModifier);
                    $exitRangeEnd = $timeTo->copy()->add($rangeModifier);

                    $entry = $dailyResults->filter(
                        fn($assist) =>
                        Carbon::parse($assist->datetime)->between($entryRangeStart, $entryRangeEnd)
                    )->sortBy(
                        fn($assist) =>
                        abs(Carbon::parse($assist->datetime)->diffInSeconds($timeFrom))
                    )->first();

                    if ($entry) {
                        unset($dailyResults[$entry->id]);
                        unset($results[$entry->id]);
                    }

                    $exit = $dailyResults->filter(
                        fn($assist) =>
                        Carbon::parse($assist->datetime)->between($exitRangeStart, $exitRangeEnd)
                    )->sortBy(
                        fn($assist) =>
                        abs(Carbon::parse($assist->datetime)->diffInSeconds($timeTo))
                    )->first();

                    if ($exit) {
                        unset($dailyResults[$exit->id]);
                        unset($results[$exit->id]);
                    }

                    return [
                        $entry ? Carbon::parse($entry->datetime) : null,
                        $exit ? Carbon::parse($exit->datetime) : null,
                    ];
                };

                [$morningMarkedIn, $morningMarkedOut] = $calculateAttendance(
                    $schedule['morningFrom'],
                    $schedule['morningTo'],
                    $dailyResults,
                    $results,
                    CarbonInterval::minutes(120),

                );

                [$afternoonMarkedIn, $afternoonMarkedOut] = $calculateAttendance(
                    $schedule['afternoonFrom'],
                    $schedule['afternoonTo'],
                    $dailyResults,
                    $results,
                    CarbonInterval::minutes(120),
                );

                // If there are still assists left, try to match them with the schedule
                if ((!$morningMarkedIn || !$morningMarkedOut || !$afternoonMarkedIn || !$afternoonMarkedOut) && $dailyResults->isNotEmpty()) {
                    $remainingEntry = $dailyResults->sortBy(
                        fn($assist) => abs(Carbon::parse($assist->datetime)->diffInSeconds($schedule['morningFrom'] ?? $schedule['afternoonFrom']))
                    )->first();

                    if ($remainingEntry) {
                        $entryTime = Carbon::parse($remainingEntry->datetime);

                        if (!$morningMarkedIn && $entryTime < ($schedule['morningTo'] ?? $schedule['afternoonFrom'])) {
                            $morningMarkedIn = $entryTime;
                        } elseif (!$morningMarkedOut && $entryTime < ($schedule['afternoonFrom'] ?? $schedule['morningTo'])) {
                            $morningMarkedOut = $entryTime;
                        } elseif (!$afternoonMarkedIn && $entryTime >= ($schedule['morningTo'] ?? $schedule['afternoonFrom'])) {
                            $afternoonMarkedIn = $entryTime;
                        } elseif (!$afternoonMarkedOut) {
                            $afternoonMarkedOut = $entryTime;
                        }

                        unset($dailyResults[$remainingEntry->id]);
                        unset($results[$remainingEntry->id]);
                    }
                }

                if ($morningMarkedIn && !$morningMarkedOut && !$afternoonMarkedIn && $afternoonMarkedOut) {
                    $morningMarkedOut = $schedule['morningTo'];
                    $afternoonMarkedIn = $schedule['afternoonFrom'];
                }

                return array_merge($schedule, [
                    'user' => $users->find($schedule['userId'])
                ], [
                    'morningMarkedIn' => $morningMarkedIn,
                    'morningMarkedOut' => $morningMarkedOut,
                    'afternoonMarkedIn' => $afternoonMarkedIn,
                    'afternoonMarkedOut' => $afternoonMarkedOut,
                ]);
            });

            // $restAssists = $results->map(function ($record) use ($terminals, $users) {
            //     $record->terminal = $terminals->where('id', $record->terminalId)->first();
            //     $record->user = $users->where('documentId', $record->documentId)->first();
            //     return $record;
            // })->values();

            $groupedAssists = $updatedSchedules->groupBy('userId')->map(function ($userSchedules) {
                return $userSchedules->groupBy('date');
            });

            $spreadsheet = IOFactory::load(public_path('templates/assists.xlsx'));
            $worksheet = $spreadsheet->getActiveSheet();

            $rr = 4;


            foreach ($groupedAssists as $userId => $dates) {
                foreach ($dates as $date => $schedules) {
                    foreach ($schedules as $schedule) {
                        $formatParsed = Carbon::parse($schedule['date']);
                        $morningFromMoreTolerence = $schedule['morningFrom'] ? Carbon::parse($schedule['morningFrom'])->addMinutes($schedule['tolerence']) : null;
                        $afternoonFromMoreTolerence = $schedule['afternoonFrom'] ? Carbon::parse($schedule['afternoonFrom'])->addMinutes($schedule['tolerence']) : null;

                        $worksheet->setCellValue('A' . $rr, $rr - 3);
                        $worksheet->setCellValue('B' . $rr, $formatParsed->format('d/m/Y'));
                        $worksheet->getStyle('B' . $rr)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                        $worksheet->setCellValue('C' . $rr, ($schedule['user']?->branch?->name));
                        $worksheet->setCellValue('D' . $rr, ($schedule['user']?->firstNames && $schedule['user']?->lastNames) ? $schedule['user']?->lastNames . ', ' .  $schedule['user']?->firstNames : $schedule['user']?->displayName);

                        // nombre del mes
                        $worksheet->setCellValue('E' . $rr, $schedule['user']?->role?->department?->area?->name ?? "");

                        // Morning
                        $worksheet->setCellValue('F' . $rr, $schedule['morningFrom'] ? $schedule['morningFrom']->format('H:i') : "");
                        $worksheet->getStyle('F' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('G' . $rr, $morningFromMoreTolerence ? $morningFromMoreTolerence->format('H:i') : "");
                        $worksheet->getStyle('G' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('H' . $rr, $schedule['morningTo'] ? $schedule['morningTo']->format('H:i') : "");
                        $worksheet->getStyle('H' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                        // Afternoon
                        $worksheet->setCellValue('I' . $rr, $schedule['afternoonFrom'] ? $schedule['afternoonFrom']->format('H:i') : "");
                        $worksheet->getStyle('I' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('J' . $rr, $afternoonFromMoreTolerence ? $afternoonFromMoreTolerence->format('H:i') : "");
                        $worksheet->getStyle('J' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('K' . $rr, $schedule['afternoonTo'] ? $schedule['afternoonTo']->format('H:i') : "");
                        $worksheet->getStyle('K' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                        // ------------- Assists -------------
                        // Morning
                        $worksheet->setCellValue('P' . $rr, $schedule['morningMarkedIn'] ? $schedule['morningMarkedIn']->format('H:i:s') : "");
                        $worksheet->getStyle('P' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('Q' . $rr, $schedule['morningMarkedOut'] ? $schedule['morningMarkedOut']->format('H:i:s') : "");
                        $worksheet->getStyle('Q' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                        // Afternoon
                        $worksheet->setCellValue('R' . $rr, $schedule['afternoonMarkedIn'] ? $schedule['afternoonMarkedIn']->format('H:i:s') : "");
                        $worksheet->getStyle('R' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');
                        $worksheet->setCellValue('S' . $rr, $schedule['afternoonMarkedOut'] ? $schedule['afternoonMarkedOut']->format('H:i:s') : "");
                        $worksheet->getStyle('S' . $rr)->getNumberFormat()->setFormatCode('HH:MM:SS');

                        $rr++;
                    }
                }
            }

            Storage::makeDirectory('reports');

            $fileId = now()->timestamp;
            $filePath = 'reports/' . $fileId . '.xlsx';

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/' . $filePath));

            $fileName = $this->startDate . ' - ' . $this->endDate . ' Asistencias con horarios';

            $report = Report::create([
                'fileId' => $fileId,
                'title' => $fileName,
                'ext' => 'xlsx',
                'creatorId' => $user->id,
                'module' => 'assists',
            ]);

            $downloadLink = config('app.download_url') . '/reports/' . $report->id;

            ReportSendEmail::dispatch($report->title, 'asistencias', 'las asistencias', $downloadLink, $user->id);
        }
    }
}
