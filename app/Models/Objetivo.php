<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Objetivo
 *
 * @property $id
 * @property $id_colaborador
 * @property $objetivo
 * @property $descripcion
 * @property $porcentaje
 * @property $indicadores
 * @property $fecha_vencimiento
 * @property $puntaje_01
 * @property $fecha_calificacion_1
 * @property $fecha_aprobacion_1
 * @property $puntaje_02
 * @property $fecha_calificacion_2
 * @property $fecha_aprobacion_2
 * @property $aprobado
 * @property $aprovado_ev_1
 * @property $aprovado_ev_2
 * @property $año_actividad
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Objetivo extends Model
{
  static $rules = [
    'objetivo' => 'required',
    'descripcion' => 'required',
    'porcentaje' => 'required|numeric|gt:0|lte:100', // Asegura que sea numérico, mayor que 0 y menor o igual a 100
    'indicadores' => 'required',
    'año_actividad' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['id_colaborador', 'objetivo', 'descripcion', 'porcentaje', 'indicadores', 'fecha_vencimiento', 'puntaje_01', 'fecha_calificacion_1', 'fecha_aprobacion_1', 'puntaje_02', 'fecha_calificacion_2', 'fecha_aprobacion_2', 'aprobado', 'aprovado_ev_1', 'aprovado_ev_2', 'año_actividad'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function colaboradore()
  {
    return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
  }
}
