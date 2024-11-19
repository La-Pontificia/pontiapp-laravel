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
        'user_id',
        'from',
        'to',
        'title',
        'created_by',
        'updated_by',
        'terminal_id',
        'title',
        'days',
        'start_date',
        'end_date',
        'archived',
    ];

    protected $casts = [
        'days' => 'array',
    ];


    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function terminal()
    {
        return $this->hasOne(AssistTerminal::class, 'id', 'terminal_id');
    }
}
