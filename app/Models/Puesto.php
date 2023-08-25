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
		'codigo_puesto' => 'required',
		'nombre_puesto' => 'required',
		'id_departamento' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo_puesto','nombre_puesto','id_departamento'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colaboradores()
    {
        return $this->hasMany('App\Models\Colaboradore', 'id_puesto', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function departamento()
    {
        return $this->hasOne('App\Models\Departamento', 'id', 'id_departamento');
    }
    

}
