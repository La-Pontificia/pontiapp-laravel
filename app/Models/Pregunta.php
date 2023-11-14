<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pregunta
 *
 * @property $id
 * @property $pregunta
 * @property $created_at
 * @property $updated_at
 *
 * @property CuestionarioPreguntum[] $cuestionarioPreguntas
 * @property PlantillaPreguntum[] $plantillaPreguntas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pregunta extends Model
{

    static $rules = [
        'pregunta' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['pregunta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cuestionarioPreguntas()
    {
        return $this->hasMany('App\Models\CuestionarioPreguntum', 'id_pregunta', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plantillaPreguntas()
    {
        return $this->hasMany('App\Models\PlantillaPreguntum', 'id_pregunta', 'id');
    }
}
