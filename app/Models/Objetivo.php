<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Objetivo
 *
 * @property $id
 * @property $id_colaborador
 * @property $id_supervisor
 * @property $objetivo
 * @property $descripcion
 * @property $indicadores
 * @property $porcentaje
 * @property $estado
 * @property $estado_fecha
 * @property $feedback
 * @property $feedback_fecha
 * @property $nota_colab
 * @property $nota_super
 * @property $nota_super_fecha
 * @property $eva
 * @property $año
 * @property $notify_super
 * @property $notify_colab
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Objetivo extends Model
{

    static $rules = [
        // 'id_colaborador' => 'required',
        // 'id_supervisor' => 'required',
        'objetivo' => 'required',
        'descripcion' => 'required',
        'indicadores' => 'required',
        'porcentaje' => 'required|numeric|gt:0|lte:100',
        // 'estado' => 'required',
        // 'feedback' => 'required',
        'nota_colab' => 'required',
        // 'nota_super' => 'required',
        // 'eva' => 'required',
        // 'notify_super' => 'required',
        // 'notify_colab' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_colaborador', 'id_supervisor', 'objetivo', 'descripcion', 'indicadores', 'porcentaje', 'porcentaje_inicial', 'estado', 'estado_fecha', 'feedback', 'feedback_fecha', 'nota_colab', 'nota_super', 'nota_super_fecha', 'eva', 'año', 'notify_super', 'notify_colab'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaborador()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supervisor()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_supervisor');
    }
}
