<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 *
 * @property $id
 * @property $codigo_departamento
 * @property $nombre_departamento
 * @property $id_area
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @property Puesto[] $puestos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Departamento extends Model
{

    static $rules = [
        'nombre' => 'required',
        'id_area' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo', 'nombre', 'id_area'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'id_area');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function puestos()
    {
        return $this->hasMany('App\Models\Puesto', 'id_departamento', 'id');
    }
}
