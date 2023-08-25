<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Acceso
 *
 * @property $id
 * @property $modulo
 * @property $acceso
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
		'acceso' => 'required',
		'id_colaborador' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['modulo','acceso','id_colaborador'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }
    

}
