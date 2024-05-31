<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasUuids;

    protected $perPage = 20;

    protected $fillable = ['id', 'id_usuario', 'nombre', 'hora_entrada', 'hora_salida', 'limite_entrada', 'limite_salida', 'id_usuario_admin'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function usuario()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_usuario');
    }

    public function usuarioAdmin()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_usuario_admin');
    }
}
