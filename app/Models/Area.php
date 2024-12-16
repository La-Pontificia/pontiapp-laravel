<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Area extends Model
{


  use HasUuids;

  protected $table = 'user_areas';

  protected $perPage = 20;

  protected $fillable = ['codePrefix', 'name', 'updatedBy', 'createdBy'];
  protected $keyType = 'string';
  public $incrementing = false;


  public function departments()
  {
    return $this->hasMany(Department::class, 'areaId', 'id');
  }

  public function createdUser()
  {
    return $this->hasOne(User::class, 'id', 'createdBy');
  }

  public function updatedUser()
  {
    return $this->hasOne(User::class, 'id', 'updatedBy');
  }
}
