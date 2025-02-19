<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
