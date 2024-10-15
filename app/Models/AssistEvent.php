<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistEvent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'assist_events';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'document_id',
        'first_name',
        'first_surname',
        'second_surname',
        'career',
        'event_id',
        'institution',
        'sex',
        'period',
        'email',
    ];

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }
}
