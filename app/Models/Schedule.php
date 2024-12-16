<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
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
        'title',
        'createdBy',
        'updatedBy',
        'assistTerminalId',
        'title',
        'days',
        'startDate',
        'endDate',
        'archived',
    ];

    protected $casts = [
        'days' => 'array',

    ];


    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function terminal()
    {
        return $this->hasOne(AssistTerminal::class, 'id', 'assistTerminalId');
    }
}
