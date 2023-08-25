<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supervisore
 *
 * @property $id
 * @property $id_colaborador
 * @property $id_supervisor
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supervisore extends Model
{

    static $rules = [
        'id_colaborador' => 'required',
        'id_supervisor' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_colaborador', 'id_supervisor'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supervisores()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_supervisor');
    }
}
