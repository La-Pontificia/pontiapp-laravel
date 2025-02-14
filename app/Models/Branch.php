<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

  use HasUuids;

  protected $table = 'rm_branches';

  static $rules = [
    'name' => 'required',
    'address' => 'required',
  ];

  protected $perPage = 20;

  protected $keyType = 'string';

  public $incrementing = false;

  protected $fillable = ['name', 'address', 'creatorId'];

  public function creator()
  {
    return $this->hasOne(User::class, 'id', 'creatorId');
  }
}
