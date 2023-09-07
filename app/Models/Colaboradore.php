<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Colaboradore
 *
 * @property $id
 * @property $dni
 * @property $apellidos
 * @property $nombres
 * @property $estado
 * @property $id_cargo
 * @property $id_puesto
 * @property $id_usuario
 * @property $created_at
 * @property $updated_at
 *
 * @property Cargo $cargo
 * @property Puesto $puesto
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Colaboradore extends Model
{

    static $rules = [
        'dni' => 'required|numeric|digits:8', // Asegura que sea numérico y tenga 8 dígitos
        'apellidos' => 'required',
        'nombres' => 'required',
        'id_cargo' => 'required',
        'id_puesto' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['dni', 'apellidos', 'nombres', 'estado', 'id_cargo', 'id_puesto', 'id_usuario'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cargo()
    {
        return $this->hasOne('App\Models\Cargo', 'id', 'id_cargo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function puesto()
    {
        return $this->hasOne('App\Models\Puesto', 'id', 'id_puesto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_usuario');
    }
}
