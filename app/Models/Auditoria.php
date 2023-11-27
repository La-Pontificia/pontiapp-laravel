<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Auditoria
 *
 * @property $id
 * @property $id_colab
 * @property $titulo
 * @property $descripcion
 * @property $modulo
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Auditoria extends Model
{

  static $rules = [
    'id_colab' => 'required',
    'titulo' => 'required',
    'descripcion' => 'required',
    'modulo' => 'required',
  ];

  protected $table = 'auditoria';
  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['id_colab', 'titulo', 'descripcion', 'modulo'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function colaborador()
  {
    return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colab');
  }
}
