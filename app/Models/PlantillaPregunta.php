<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlantillaPreguntum
 *
 * @property $id
 * @property $id_plantilla
 * @property $id_pregunta
 * @property $created_at
 * @property $updated_at
 *
 * @property Plantilla $plantilla
 * @property Pregunta $pregunta
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PlantillaPregunta extends Model
{

    use HasUuids;
    static $rules = [
        'id_plantilla' => 'required',
        'id_pregunta' => 'required',
    ];

    protected $table = 'plantilla_pregunta';
    protected $perPage = 20;
    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_plantilla', 'id_pregunta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plantilla()
    {
        return $this->hasOne('App\Models\Plantilla', 'id', 'id_plantilla');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pregunta()
    {
        return $this->hasOne('App\Models\Pregunta', 'id', 'id_pregunta');
    }
}
