<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    use HasUuids;
    static $rules = [
        'dni' => 'required|numeric|digits:8', // Asegura que sea numérico y tenga 8 dígitos
        'apellidos' => 'required',
        'nombres' => 'required',
        'id_cargo' => 'required',
        'rol' => 'required',
    ];

    protected $casts = [
        'privilegios' => 'array',
    ];

    protected $perPage = 25;


    protected $fillable = ['dni', 'privilegios', 'apellidos', 'nombres', 'correo_institucional', 'perfil', 'rol', 'estado', 'id_cargo', 'id_usuario', 'id_sede', 'id_supervisor'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function sede()
    {
        return $this->hasOne('App\Models\Sede', 'id', 'id_sede');
    }

    public function cargo()
    {
        return $this->hasOne('App\Models\Cargo', 'id', 'id_cargo');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_usuario');
    }

    public function supervisor()
    {
        return $this->belongsTo(Colaboradore::class, 'id_supervisor');
    }
}
