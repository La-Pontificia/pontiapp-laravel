<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'tickets';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'document_id',
        'paternal_surname',
        'maternal_surname',
        'names',
        'affair',
        'business_id',
        'user_id',
        'state',
        'number',

    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function business()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'business_id');
    }

    public function lastnames()
    {
        return $this->paternal_surname . ' ' . $this->maternal_surname;
    }
}
