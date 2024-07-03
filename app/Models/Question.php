<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{

  use HasUuids;

  protected $table = 'questions';

  protected $perPage = 20;

  protected $fillable = ['question', 'order', 'id_template', 'created_by', 'udpated_by'];

  protected $keyType = 'string';

  public $incrementing = false;

  public function template()
  {
    return $this->hasOne('App\Models\Template', 'id_template', 'id');
  }

  public function createdBy()
  {
    return $this->hasOne('App\Models\User', 'created_by', 'id');
  }

  public function updatedBy()
  {
    return $this->hasOne('App\Models\User', 'updated_by', 'id');
  }
}
