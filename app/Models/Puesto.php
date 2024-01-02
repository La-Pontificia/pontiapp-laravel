<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Puesto
 *
 * @property $id
 * @property $codigo_puesto
 * @property $nombre_puesto
 * @property $id_departamento
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore[] $colaboradores
 * @property Departamento $departamento
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Puesto extends Model
{

    static $rules = [
        'nombre_puesto' => 'required',

    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo_puesto', 'nombre_puesto'];
}
