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
        'id_user',
        'assigned_by',
        'reason',
        'email',
        'discharged',
        'discharged_by',
        'created_at',
        'updated_at',
    ];

    static $rules = [
        'id_uer' => ['required', 'uuid'],
        'reason' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function assignedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'assigned_by');
    }

    public function dischargedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'discharged_by');
    }
}
