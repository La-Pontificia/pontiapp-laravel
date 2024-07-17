<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'emails';

    protected $fillable = [
        'id',
        'user_id',
        'assigned_by',
        'description',
        'email',
        'discharged',
        'access',
        'discharged_by',
        'created_at',
        'updated_at',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function assignedBy()
    {
        return $this->hasOne(User::class, 'id', 'assigned_by');
    }

    public function dischargedBy()
    {
        return $this->hasOne(User::class, 'id', 'discharged_by');
    }
}
