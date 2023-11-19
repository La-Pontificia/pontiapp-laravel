<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CuestionarioPreguntum
 *
 * @property $id
 * @property $id_cuestionario
 * @property $id_pregunta
 * @property $respuesta
 * @property $created_at
 * @property $updated_at
 *
 * @property Cuestionario $cuestionario
 * @property Pregunta $pregunta
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CuestionarioPregunta extends Model
{

    static $rules = [
        'id_cuestionario' => 'required',
        'id_pregunta' => 'required',
        'respuesta' => 'required',
    ];

    protected $table = 'cuestionario_pregunta';
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_cuestionario', 'id_pregunta', 'respuesta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cuestionario()
    {
        return $this->hasOne('App\Models\Cuestionario', 'id', 'id_cuestionario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pregunta()
    {
        return $this->hasOne('App\Models\Pregunta', 'id', 'id_pregunta');
    }
}
