<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EdaEvaluationObjetive extends Model
{
    use HasUuids;

    protected $table = 'edas_objetive_evaluation';

    protected $perPage = 20;

    protected $fillable = [
        'objetiveId',
        'qualification',
        'selftQualification',
        'evaluationId',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function objetive()
    {
        return $this->hasOne(EdaObjetive::class, 'id', 'objetiveId');
    }

    public function evaluation()
    {
        return $this->hasOne(EdaEvaluation::class, 'id', 'evaluationId');
    }
}
