<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attention extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'attentions';

    protected $perPage = 30;

    protected $fillable = [
        'attentionPositionId',
        'attendantId',
        'personDocumentId',
        'personFirstnames',
        'personLastnames',
        'personCareer',
        'personPeriodName',
        'personGender',
        'personEmail',
        'startAttend',
        'finishAttend',
        'ticket',
        'attentionDescripcion',
    ];

    protected $casts = [
        'ticket' => 'array',
    ];

    public function position()
    {
        return $this->hasOne(AttentionPosition::class, 'id', 'attentionPositionId');
    }

    public function attendant()
    {
        return $this->hasOne(User::class, 'id', 'attendantId');
    }
}
