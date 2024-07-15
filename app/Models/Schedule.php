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
    ];

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'updated_by', 'id');
    }

    public function groupSchedules()
    {
        return $this->hasOne('App\Models\GroupSchedule', 'id', 'group_id');
    }
}
