<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Eda extends Model
{

  use HasUuids;

  static $rules = [
    'año' => 'required'
  ];

  protected $perPage = 20;


  protected $fillable = ['año', 'cerrado'];
  protected $keyType = 'string';
  public $incrementing = false;


  public function edaColabs()
  {
    return $this->hasMany('App\Models\EdaColab', 'id_eda', 'id');
  }
}
