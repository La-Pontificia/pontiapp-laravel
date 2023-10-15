<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Acceso
 *
 * @property $id
 * @property $modulo
 * @property $crear
 * @property $leer
 * @property $actualizar
 * @property $eliminar
 * @property $id_colaborador
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Acceso extends Model
{
    
    static $rules = [
		'modulo' => 'required',
		'crear' => 'required',
		'leer' => 'required',
		'actualizar' => 'required',
		'eliminar' => 'required',
		'id_colaborador' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['modulo','crear','leer','actualizar','eliminar','id_colaborador'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }
    

}
