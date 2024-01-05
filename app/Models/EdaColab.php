<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    use HasUuids;
    static $rules = [
        'id_eda' => 'required',
        'id_colaborador' => 'required',
        'id_evaluacion' => 'required',
        'id_evaluacion_2' => 'required',
    ];

    protected $perPage = 20;
    protected $fillable = ['id_eda', 'id_colaborador', 'id_feedback_1', 'id_feedback_2', 'id_evaluacion', 'id_evaluacion_2', 'id_cuestionario_colab', 'id_cuestionario_super', 'enviado', 'aprobado', 'cerrado', 'fecha_envio', 'fecha_aprobado', 'fecha_cerrado', 'promedio'];

    protected $keyType = 'string';
    public $incrementing = false;

    public function colaborador()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }
    public function eda()
    {
        return $this->hasOne('App\Models\Eda', 'id', 'id_eda');
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'id_feedback_1');
    }

    public function feedback2()
    {
        return $this->belongsTo(Feedback::class, 'id_feedback_2');
    }

    public function evaluacion2()
    {
        return $this->hasOne('App\Models\Evaluacione', 'id', 'id_evaluacion_2');
    }

    public function evaluacion()
    {
        return $this->hasOne('App\Models\Evaluacione', 'id', 'id_evaluacion');
    }

    public function objetivos()
    {
        return $this->hasMany('App\Models\Objetivo', 'id_eda_colab', 'id');
    }


    public function cuestionarioColab()
    {
        return $this->hasOne('App\Models\Cuestionario', 'id', 'id_cuestionario_colab');
    }

    public function cuestionarioSuper()
    {
        return $this->hasOne('App\Models\Cuestionario', 'id', 'id_cuestionario_super');
    }
}
