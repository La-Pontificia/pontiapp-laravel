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
    'open',
    'closed',
    'send',
    'overage',
    'approved',
    'created_at',
    'created_by',
    'updated_at',
    'approved_by',
    'closed_by',
  ];

  static $rules = [
    'id_year' => ['required', 'string', 'max:36'],
    'id_user' => ['required', 'string', 'max:36'],
  ];


  protected $keyType = 'string';

  public $incrementing = false;

  public function user()
  {
    return $this->hasOne('App\Models\User', 'id', 'id_user');
  }

  public function createdBy()
  {
    return $this->hasOne('App\Models\User', 'id', 'created_by');
  }

  public function approvedBy()
  {
    return $this->hasOne('App\Models\User', 'id', 'approved_by');
  }
  public function closedBy()
  {
    return $this->hasOne('App\Models\User', 'id', 'closed_by');
  }

  public function year()
  {
    return $this->hasOne('App\Models\Year', 'id', 'id_year');
  }

  public function evaluations()
  {
    return $this->hasMany('App\Models\Evaluation', 'id_eda', 'id');
  }
}
