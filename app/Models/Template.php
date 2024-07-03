<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Template extends Model
{

  use HasUuids;

  protected $table = 'templates';

  protected $perPage = 20;

  protected $fillable = ['title', 'for', 'in_use', 'created_by', 'udpated_by'];

  protected $keyType = 'string';

  public $incrementing = false;


  public function createdBy()
  {
    return $this->hasOne('App\Models\User', 'id', 'created_by');
  }

  public function updatedBy()
  {
    return $this->hasOne('App\Models\User', 'id', 'updated_by');
  }

  public function questions()
  {
    return $this->hasMany('App\Models\Question', 'id_template', 'id');
  }
}
