<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'questionnaire_answers';

    protected $perPage = 20;

    protected $fillable = ['answer', 'question_id', 'questionnaire_id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function questionnaire()
    {
        return $this->hasOne(QuestionnaireTemplate::class, 'id', 'questionnaire_id');
    }
}
