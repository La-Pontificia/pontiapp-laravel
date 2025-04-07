<?php

namespace App\Models;

use App\Models\Rm\BusinessUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRecord extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'events_records';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'documentId',
        'firstNames',
        'lastNames',
        'fullName',
        'career',
        'eventId',
        'institution',
        'gender',
        'period',
        'email',
        'businessUnitId'
    ];

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'eventId');
    }

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'businessUnitId');
    }
}
