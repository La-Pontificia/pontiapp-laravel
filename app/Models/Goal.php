<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasUuids;

    protected $table = 'goals';

    static $rules = [
        'goal' => ['required', 'string', 'max:500'],
        'description' => ['required', 'string', 'max:2000'],
        'indicators' => ['required', 'string', 'max:2000'],
        'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        'id_eda' => ['required', 'max:36'],
    ];

    protected $perPage = 20;

    protected $fillable = [
        'id_eda',
        'goal',
        'description',
        'indicators',
        'percentage',
        'self_qualification',
        'self_qualification_2',
        'average',
        'average_2',
        'created_by'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function eda()
    {
        return $this->hasOne('App\Models\Eda', 'id', 'id_eda');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
