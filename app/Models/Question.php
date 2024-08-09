<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{

  use HasUuids;

  protected $table = 'questions';

  protected $perPage = 20;

  protected $fillable = ['question', 'order', 'template_id', 'created_by', 'udpated_by'];

  protected $keyType = 'string';

  public $incrementing = false;

  public function template()
  {
    return $this->hasOne(QuestionnaireTemplate::class, 'template_id', 'id');
  }

  public function createdBy()
  {
    return $this->hasOne(User::class, 'created_by', 'id');
  }

  public function updatedBy()
  {
    return $this->hasOne(User::class, 'updated_by', 'id');
  }
}
