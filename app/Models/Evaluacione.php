<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evaluacione
 *
 * @property $id
 * @property $promedio
 * @property $autocalificacion
 * @property $cerrado
 * @property $fecha_promedio
 * @property $fecha_autocalificacion
 * @property $fecha_cerrado
 * @property $created_at
 * @property $updated_at
 *
 * @property EdaColab[] $edaColabs
 * @property EdaColab[] $edaColabs
 * @property Feedback[] $feedbacks
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Evaluacione extends Model
{
    use HasUuids;

    static $rules = [
        'cerrado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['promedio', 'autocalificacion', 'cerrado', 'fecha_promedio', 'fecha_autocalificacion', 'fecha_cerrado'];

    protected $keyType = 'string';
    public $incrementing = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edaColabs()
    {
        return $this->hasMany('App\Models\EdaColab', 'id_evaluacion_2', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edaColabs2()
    {
        return $this->hasMany('App\Models\EdaColab', 'id_evaluacion', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback', 'id_evaluacion', 'id');
    }
}
