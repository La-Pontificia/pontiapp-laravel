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
        'qualification',
        'self_qualification',
        'closed',
        'closed_by',
        'closed_at',
        'self_rated_at',
        'self_rated_by',
        'qualified_at',
        'qualified_by',

        'feedback',
        'feedback_by',
        'feedback_score',
        'feedback_at',
        'feedback_read_at',

    ];

    protected $casts = [
        'feedback_read_at' => 'datetime',
        'feedback_at' => 'datetime',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function eda()
    {
        return $this->hasOne(Eda::class, 'id', 'id_eda');
    }

    public function closedBy()
    {
        return $this->hasOne(User::class, 'id', 'closed_by');
    }

    public function goalsEvaluations()
    {
        return $this->hasMany(GoalEvaluation::class, 'id_evaluation', 'id');
    }

    public function selfRatedBy()
    {
        return $this->hasOne(User::class, 'id', 'self_rated_by');
    }

    public function qualifiedBy()
    {
        return $this->hasOne(User::class, 'id', 'qualified_by');
    }

    public function feedbackBy()
    {
        return $this->hasOne(User::class, 'id', 'feedback_by');
    }
}
