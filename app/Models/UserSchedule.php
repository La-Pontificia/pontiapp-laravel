<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserSchedule extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'user_schedules';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'userId',
        'from',
        'to',
        'creatorId',
        'updaterId',
        'days',
        'startDate',
        'endDate',
        'archived',
        'type',
        'tolerance',
    ];

    protected $casts = [
        'days' => 'array',
    ];


    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function getDatesAttribute(): Collection
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = $this->endDate ? Carbon::parse($this->endDate) : $startDate->copy()->addYear();
        $daysOfWeek = collect($this->days);
        $scheduleList = collect();

        while ($startDate->lte($endDate)) {
            if ($daysOfWeek->contains($startDate->dayOfWeekIso)) {
                $scheduleList->push($startDate->toDateString());
            }
            $startDate->addDay();
        }

        return $scheduleList;
    }
}
