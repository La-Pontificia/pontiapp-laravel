<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 *
 * @property $id
 * @property $id_emisor
 * @property $id_evaluacion
 * @property $feedback
 * @property $calificacion
 * @property $recibido
 * @property $fecha_recibido
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Evaluacione $evaluacione
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Feedback extends Model
{

    static $rules = [
        'id_emisor' => 'required',
        'id_evaluacion' => 'required',
        'recibido' => 'required',
    ];

    protected $table = 'feedbacks';
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_emisor', 'id_evaluacion', 'feedback', 'calificacion', 'recibido', 'fecha_recibido'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_emisor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function evaluacione()
    {
        return $this->hasOne('App\Models\Evaluacione', 'id', 'id_evaluacion');
    }
}
