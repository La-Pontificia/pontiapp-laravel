<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Eda extends Model
{
  use HasUuids;

  protected $table = 'edas';

  protected $perPage = 20;

  protected $fillable = [
    'id',
    'id_year',
    'id_user',
    'closed',
    'send',
    'approved',
    'created_at',
    'updated_at',
    'created_by',
    'approved_by',
    'closed_by',
    'sent_by',
  ];

  static $rules = [
    'id_year' => ['required', 'string', 'max:36'],
    'id_user' => ['required', 'string', 'max:36'],
  ];


  protected $keyType = 'string';

  public $incrementing = false;

  public function collaboratorQuestionnaire()
  {
    return $this->hasOne(Questionnaire::class, 'eda_id', 'id')
      ->whereHas('template', function ($q) {
        $q->where('use_for', 'collaborators');
      });
  }

  public function supervisorQuestionnaire()
  {
    return $this->hasOne(Questionnaire::class, 'eda_id', 'id')
      ->whereHas('template', function ($q) {
        $q->where('use_for', 'supervisors');
      });
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'id_user');
  }

  public function goals()
  {
    return $this->hasMany(Goal::class, 'id_eda', 'id');
  }

  public function createdBy()
  {
    return $this->hasOne(User::class, 'id', 'created_by');
  }

  public function approvedBy()
  {
    return $this->hasOne(User::class, 'id', 'approved_by');
  }

  public function closedBy()
  {
    return $this->hasOne(User::class, 'id', 'closed_by');
  }

  public function sentBy()
  {
    return $this->hasOne(User::class, 'id', 'sent_by');
  }

  public function year()
  {
    return $this->hasOne(Year::class, 'id', 'id_year');
  }

  public function evaluations()
  {
    return $this->hasMany(Evaluation::class, 'id_eda', 'id');
  }
}
