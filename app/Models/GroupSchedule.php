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

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule', 'group_id', 'id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
