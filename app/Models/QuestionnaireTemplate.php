<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class QuestionnaireTemplate extends Model
{

  use HasUuids;

  protected $table = 'questionnaire_templates';

  protected $perPage = 20;

  protected $fillable = [
    'title',
    'for',
    'in_use',
    'archived'
  ];

  protected $keyType = 'string';

  public $incrementing = false;

  protected $hidden = [
    'archived',
    'created_by',
    'updated_by',
  ];

  public function questions()
  {
    return $this->hasMany(Question::class, 'template_id', 'id')->where('archived', false)->orderBy('order');
  }

  public function allQuestions()
  {
    return $this->hasMany(Question::class, 'template_id', 'id');
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
