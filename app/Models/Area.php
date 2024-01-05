<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 *
 * @property $id
 * @property $codigo_area
 * @property $nombre_area
 * @property $created_at
 * @property $updated_at
 *
 * @property Departamento[] $departamentos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model
{

  use HasUuids;

  static $rules = [
    // 'codigo_area' => 'required',
    'nombre' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['codigo', 'nombre'];
  protected $keyType = 'string';
  public $incrementing = false;


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function departamentos()
  {
    return $this->hasMany('App\Models\Departamento', 'id_area', 'id');
  }
}
