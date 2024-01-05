<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sede
 *
 * @property $id
 * @property $nombre
 * @property $direccion
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sede extends Model
{

  use HasUuids;
  static $rules = [
    'nombre' => 'required',
  ];

  protected $perPage = 20;
  protected $keyType = 'string';
  public $incrementing = false;
  protected $fillable = ['nombre', 'direccion'];
}
