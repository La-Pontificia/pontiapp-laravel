<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'events';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'description',
        'date',
        'creatorId',
        'updaterId',
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
    ];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function records()
    {
        return $this->hasMany(EventRecord::class, 'eventId', 'id');
    }

    public function recordsCount()
    {
        return $this->records()->count();
    }
}
