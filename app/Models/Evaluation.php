<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasUuids;

    protected $table = 'evaluations';

    protected $perPage = 20;

    protected $fillable = [
        'number',
        'id_eda',
        'overage',
        'self_qualification',
        'closed',
        'closed_by',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function eda()
    {
        return $this->hasOne('App\Models\Eda', 'id', 'id_eda');
    }

    public function closedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'closed_by');
    }

    public function goal()
    {
        return $this->hasMany('App\Models\Goal', 'id_evaluation', 'id');
    }
}
