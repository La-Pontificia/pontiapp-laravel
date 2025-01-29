<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EdaEvaluation extends Model
{
    use HasUuids;

    protected $table = 'edas_evaluations';

    protected $perPage = 20;

    protected $fillable = [
        'number',
        'edaId',
        'qualification',
        'qualifierId',
        'qualificationAt',
        'selftQualification',
        'selftQualifierId',
        'selftQualificationAt',
        'closedAt',
        'closerId'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function eda()
    {
        return $this->hasOne(Eda::class, 'id', 'edaId');
    }

    public function qualifier()
    {
        return $this->hasOne(User::class, 'id', 'qualifierId');
    }

    public function selftQualifier()
    {
        return $this->hasOne(User::class, 'id', 'selftQualifierId');
    }

    public function closer()
    {
        return $this->hasOne(User::class, 'id', 'closerId');
    }

    public function objetives()
    {
        return $this->hasMany(EdaEvaluationObjetive::class, 'evaluationId', 'id');
    }
}
