<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'questionnaires';

    protected $perPage = 20;

    protected $fillable = [
        'answered_by',
        'eda_id',
        'questionnaire_template_id',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'archived',
        'created_by',
        'updated_by',
    ];

    public function template()
    {
        return $this->hasOne(QuestionnaireTemplate::class, 'id', 'questionnaire_template_id');
    }

    public function answers()
    {
        return $this->hasMany(QuestionnaireAnswer::class, 'questionnaire_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'template_id', 'id')->where('archived', false)->orderBy('order');
    }

    public function allQuestions()
    {
        return $this->hasMany(Question::class, 'template_id', 'id');
    }

    public function answeredBy()
    {
        return $this->hasOne(User::class, 'id', 'answered_by');
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
