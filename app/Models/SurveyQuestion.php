<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Survey extends Model
{

  use HasUuids;

  protected $table = 'survey_question';

  protected $perPage = 20;

  protected $fillable = ['id_survey', 'id_question', 'answer', 'answered_at'];

  protected $keyType = 'string';

  public $incrementing = false;

  public function survey()
  {
    return $this->hasOne('App\Models\Survey', 'id_user', 'id');
  }

  public function question()
  {
    return $this->hasOne('App\Models\Question', 'id_question', 'id');
  }

  public function answeredBy()
  {
    return $this->belongsTo('App\Models\User', 'answered_by', 'id');
  }
}
