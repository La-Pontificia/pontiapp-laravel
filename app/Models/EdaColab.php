<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EdaColab
 *
 * @property $id
 * @property $id_eda
 * @property $id_colaborador
 * @property $id_evaluacion
 * @property $id_evaluacion_2
 * @property $enviado
 * @property $aprobado
 * @property $cerrado
 * @property $fecha_envio
 * @property $fecha_aprobado
 * @property $fecha_cerrado
 * @property $promedio
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Eda $eda
 * @property Evaluacione $evaluacione
 * @property Evaluacione $evaluacione
 * @property Objetivo[] $objetivos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EdaColab extends Model
{

    static $rules = [
        'id_eda' => 'required',
        'id_colaborador' => 'required',
        'id_evaluacion' => 'required',
        'id_evaluacion_2' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_eda', 'id_colaborador', 'id_evaluacion', 'id_evaluacion_2', 'enviado', 'aprobado', 'cerrado', 'fecha_envio', 'fecha_aprobado', 'fecha_cerrado', 'promedio'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function eda()
    {
        return $this->hasOne('App\Models\Eda', 'id', 'id_eda');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function evaluacion2()
    {
        return $this->hasOne('App\Models\Evaluacione', 'id', 'id_evaluacion_2');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function evaluacion()
    {
        return $this->hasOne('App\Models\Evaluacione', 'id', 'id_evaluacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objetivos()
    {
        return $this->hasMany('App\Models\Objetivo', 'id_eda_colab', 'id');
    }
}
