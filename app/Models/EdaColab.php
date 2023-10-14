<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EdaColab
 *
 * @property $id
 * @property $id_eda
 * @property $id_colaborador
 * @property $estado
 * @property $cant_obj
 * @property $nota_final
 * @property $wearing
 * @property $f_envio
 * @property $f_aprobacion
 * @property $f_cerrado
 * @property $flimit_send_obj_from
 * @property $flimit_send_obj_at
 * @property $flimit_white_autoeva_from
 * @property $flimit_white_autoeva_at
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property EdaObj[] $edaObjs
 * @property Eda $eda
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EdaColab extends Model
{

    static $rules = [
        'id_eda' => 'required',
        'id_colaborador' => 'required',
        'estado' => 'required',
        'cant_obj' => 'required',
        'nota_final' => 'required',
        'wearing' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_eda', 'id_colaborador', 'estado', 'cant_obj', 'nota_final', 'wearing', 'f_envio', 'f_aprobacion', 'f_cerrado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_colaborador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edaObjs()
    {
        return $this->hasMany('App\Models\EdaObj', 'id_eda_colab', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function eda()
    {
        return $this->hasOne('App\Models\Eda', 'id', 'id_eda');
    }
}
