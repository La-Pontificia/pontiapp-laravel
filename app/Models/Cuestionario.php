<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cuestionario
 *
 * @property $id
 * @property $id_colaborador
 * @property $id_eda
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property CuestionarioPreguntum[] $cuestionarioPreguntas
 * @property EdaColab $edaColab
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cuestionario extends Model
{

    static $rules = [
        'id_colaborador' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_colaborador'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuestionarioPreguntas()
    {
        return $this->hasMany('App\Models\CuestionarioPregunta', 'id_cuestionario', 'id');
    }
}
