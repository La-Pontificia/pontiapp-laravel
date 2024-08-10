<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{

  use HasUuids;

  protected $table = 'questions';

  protected $perPage = 20;

  protected $fillable = ['question', 'order', 'template_id', 'archived', 'created_by', 'udpated_by'];

  protected $keyType = 'string';

  public $incrementing = false;


  protected $hidden = [
    'archived',
    'created_by',
    'updated_by',
  ];

  public function template()
  {
    return $this->hasOne(QuestionnaireTemplate::class, 'id', 'template_id');
  }

  public function answers()
  {
    return $this->hasMany(QuestionnaireQuestion::class, 'question_id', 'id');
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
