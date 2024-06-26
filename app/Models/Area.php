<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Area extends Model
{


  use HasUuids;

  static $rules = [
    'name' => 'required',
  ];

  protected $table = 'areas';


  protected $perPage = 20;


  protected $fillable = ['code', 'name', 'updated_by', 'created_by'];
  protected $keyType = 'string';
  public $incrementing = false;


  public function departments()
  {
    return $this->hasMany('App\Models\Department', 'id_area', 'id');
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
