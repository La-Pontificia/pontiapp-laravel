<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Objetivo
 *
 * @property $id
 * @property $id_supervisor
 * @property $id_eda_colab
 * @property $objetivo
 * @property $descripcion
 * @property $indicadores
 * @property $porcentaje
 * @property $autoevaluacion
 * @property $nota
 * @property $editado
 * @property $nota_fecha
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property EdaColab $edaColab
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Objetivo extends Model
{

    static $rules = [
        // 'id_supervisor' => 'required',
        // 'id_eda_colab' => 'required',
        'objetivo' => 'required',
        'descripcion' => 'required',
        'indicadores' => 'required',
        'porcentaje' => 'required',
        // 'autoevaluacion' => 'required',
        // 'nota' => 'required',
        // 'editado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_supervisor', 'id_eda_colab', 'objetivo', 'descripcion', 'indicadores', 'porcentaje', 'autoevaluacion', 'nota', 'editado', 'nota_fecha'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_supervisor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function edaColab()
    {
        return $this->hasOne('App\Models\EdaColab', 'id', 'id_eda_colab');
    }
}
