<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasUuids;

    protected $table = 'goals';

    protected $perPage = 20;

    protected $fillable = [
        'id_eda',
        'title',
        'comments',
        'description',
        'indicators',
        'percentage',
        'created_by'
    ];

    protected $keyType = 'string';

    public $incrementing = false;


    public function evaluations()
    {
        return $this->hasMany(GoalEvaluation::class, 'id_goal', 'id');
    }

    public function eda()
    {
        return $this->hasOne(Eda::class, 'id', 'id_eda');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
