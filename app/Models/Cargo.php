<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 *
 * @property $id
 * @property $codigo_cargo
 * @property $nombre_cargo
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore[] $colaboradores
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cargo extends Model
{
    
    static $rules = [
		// 'codigo_cargo' => 'required',
		'nombre_cargo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo_cargo','nombre_cargo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colaboradores()
    {
        return $this->hasMany('App\Models\Colaboradore', 'id_cargo', 'id');
    }
    

}
