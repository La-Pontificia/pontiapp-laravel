<?php

namespace App\Models\Academic;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SectionCourseSchedule extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_section_course_schedules';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'sectionCourseId',
        'classroomId',
        'startDate',
        'endDate',
        'startTime',
        'endTime',
        'daysOfWeek',
        'created_at',
        'updated_at',
        'creatorId',
        'updaterId',
    ];

    protected $casts = [
        'daysOfWeek' => 'array',
        'startDate' => 'date',
        'endDate' => 'date',
        'startTime' => 'datetime',
        'endTime' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }

    public function sectionCourse()
    {
        return $this->belongsTo(SectionCourse::class, 'sectionCourseId', 'id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroomId', 'id');
    }

    public function getDatesAttribute(): Collection
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);
        $daysOfWeek = collect($this->daysOfWeek);
        $scheduleList = collect();

        while ($startDate->lte($endDate)) {
            if ($daysOfWeek->contains($startDate->dayOfWeekIso)) {
                $scheduleList->push($startDate->toDateString());
            }
            $startDate->addDay();
        }

        return $scheduleList;
    }

    // get days of the week separated by commas
    // daysOfWeek can be an array of strings ["1", "2", "3", "4", "5", "6", "7"]
    // where 1 is Monday and 7 is Sunday
    public function getDaysAttribute(): string
    {
        $daysMap = [
            '1' => 'Lunes',
            '2' => 'Martes',
            '3' => 'Miércoles',
            '4' => 'Jueves',
            '5' => 'Viernes',
            '6' => 'Sábado',
            '7' => 'Domingo',
        ];

        return collect($this->daysOfWeek)
            ->map(fn($day) => $daysMap[$day] ?? null)
            ->filter()
            ->implode(', ');
    }
}
