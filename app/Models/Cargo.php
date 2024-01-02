<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 *
 * @property $id
 * @property $codigo_cargo
 * @property $nombre_cargo
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore[] $colaboradores
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cargo extends Model
{

  static $rules = [
    'nombre_cargo' => 'required',
    'id_departamento' => 'required',
    'id_puesto' => 'required',
  ];

  protected $perPage = 25;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['codigo_cargo', 'nombre_cargo', 'id_departamento', 'id_puesto'];



  public function departamento()
  {
    return $this->hasOne('App\Models\Departamento', 'id', 'id_departamento');
  }

  public function puesto()
  {
    return $this->hasOne('App\Models\Puesto', 'id', 'id_puesto');
  }
}
