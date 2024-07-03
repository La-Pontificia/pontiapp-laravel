<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{

  use HasUuids;

  protected $table = 'question_template';

  protected $perPage = 20;

  protected $fillable = ['id_template', 'id_question'];

  protected $keyType = 'string';

  public $incrementing = false;

  public function template()
  {
    return $this->belongsTo('App\Models\Template', 'id_template', 'id');
  }

  public function question()
  {
    return $this->belongsTo('App\Models\Question', 'id_question', 'id');
  }

  public function createdBy()
  {
    return $this->belongsTo('App\Models\User', 'created_by', 'id');
  }

  public function updatedBy()
  {
    return $this->belongsTo('App\Models\User', 'updated_by', 'id');
  }
}
