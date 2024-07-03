<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Survey extends Model
{

  use HasUuids;

  protected $table = 'surveys';

  protected $perPage = 20;

  protected $fillable = ['id_user', 'id_eda'];

  protected $keyType = 'string';

  public $incrementing = false;

  public function user()
  {
    return $this->hasOne('App\Models\User', 'id_user', 'id');
  }

  public function eda()
  {
    return $this->hasOne('App\Models\Eda', 'id_eda', 'id');
  }

  public function answeredBy()
  {
    return $this->belongsTo('App\Models\User', 'answered_by', 'id');
  }

  public function surveyQuestions()
  {
    return $this->hasMany('App\Models\SurveyQuestion', 'id_survey', 'id');
  }
}
