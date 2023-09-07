<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Calificacione
 *
 * @property $id
 * @property $id_objetivo
 * @property $id_supervisor
 * @property $fecha_aprobacion
 * @property $aprobado
 * @property $pun_01
 * @property $eva_01
 * @property $apr_01
 * @property $f_apr_01
 * @property $f_eva_01
 * @property $c_01
 * @property $pun_02
 * @property $eva_02
 * @property $apr_02
 * @property $f_apr_02
 * @property $f_eva_02
 * @property $c_02
 * @property $c_eda
 * @property $c_f_eda
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Objetivo $objetivo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Calificacione extends Model
{
    
    static $rules = [
		'id_objetivo' => 'required',
		'id_supervisor' => 'required',
		'aprobado' => 'required',
		'pun_01' => 'required',
		'eva_01' => 'required',
		'apr_01' => 'required',
		'pun_02' => 'required',
		'eva_02' => 'required',
		'apr_02' => 'required',
		'c_eda' => 'required',
		'c_f_eda' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_objetivo','id_supervisor','fecha_aprobacion','aprobado','pun_01','eva_01','apr_01','f_apr_01','f_eva_01','c_01','pun_02','eva_02','apr_02','f_apr_02','f_eva_02','c_02','c_eda','c_f_eda'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_supervisor');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function objetivo()
    {
        return $this->hasOne('App\Models\Objetivo', 'id', 'id_objetivo');
    }
    

}
