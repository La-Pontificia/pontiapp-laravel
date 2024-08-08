<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSchedule extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'group_schedules';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'created_by'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'group_schedule_id', 'id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'group_id', 'id')->where('archived', false);
    }

    public function allSchedules()
    {
        return $this->hasMany(Schedule::class, 'group_id', 'id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
