<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttentionTicket extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'attentions_tickets';

    protected $perPage = 25;

    protected $fillable = [
        'attentionServiceId',
        'personDocumentId',
        'personFirstNames',
        'personLastNames',
        'personGender',
        'personCareer',
        'personPeriodName',
        'personEmail',
        'state',
        'creatorId'
    ];

    public function service()
    {
        return $this->hasOne(AttentionService::class, 'id', 'attentionServiceId');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }
}
