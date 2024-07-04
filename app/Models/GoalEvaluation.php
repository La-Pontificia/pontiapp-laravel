<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class GoalEvaluation extends Model
{
    use HasUuids;

    protected $table = 'goals_evaluations';

    protected $perPage = 20;

    protected $fillable = [
        'id_goal',
        'id_evaluation',
        'average',
        'self_qualification',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function goal()
    {
        return $this->hasOne('App\Models\Goal', 'id', 'id_goal');
    }

    public function evaluation()
    {
        return $this->hasOne('App\Models\Evaluation', 'id', 'id_evaluation');
    }
}
