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
        'group',
        'from',
        'to',
        'title',
        'id_user',
        'created_by',
        'updated_by',
        'title',
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

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id_user', 'id');
    }

    public function groupSchedules()
    {
        return $this->hasMany('App\Models\Schedule', 'group', 'id');
    }
}
