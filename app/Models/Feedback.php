<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    use HasUuids;
    static $rules = [
        'id_emisor' => 'required',
        'recibido' => 'required',
    ];

    protected $table = 'feedbacks';
    protected $perPage = 20;
    protected $fillable = ['id_emisor',  'feedback', 'calificacion', 'recibido', 'fecha_recibido'];

    protected $keyType = 'string';
    public $incrementing = false;

    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_emisor');
    }
}
