<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    use HasUuids;
    static $rules = [
        'nivel' => 'required',
        'nombre' => 'required',
    ];

    protected $perPage = 20;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['codigo', 'nivel', 'nombre'];
}
