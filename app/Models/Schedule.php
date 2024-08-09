<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'schedules';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'group_id',
        'user_id',
        'from',
        'to',
        'title',
        'created_by',
        'updated_by',
        'title',
        'days',
        'start_date',
        'end_date',
        'background',
        'archived',
        'from_start',
        'from_end',
        'to_start',
        'to_end',
    ];

    protected $casts = [
        'days' => 'array',
    ];


    public function createdBy()
    {
        return $this->hasOne(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'updated_by', 'id');
    }

    public function groupSchedules()
    {
        return $this->hasOne(GroupSchedule::class, 'id', 'group_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
