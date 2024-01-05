<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    use HasUuids;
    static $rules = [
        'pregunta' => 'required',
    ];

    protected $perPage = 20;
    protected $keyType = 'string';
    public $incrementing = false;
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
        return $this->hasMany('App\Models\CuestionarioPregunta', 'id_pregunta', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plantillaPreguntas()
    {
        return $this->hasMany('App\Models\PlantillaPregunta', 'id_pregunta', 'id');
    }
}
