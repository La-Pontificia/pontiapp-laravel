<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 *
 * @property $id
 * @property $id_transmitter
 * @property $id_receiver
 * @property $feedback
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property Colaboradore $colaboradore
 * @property Colaboradore $colaboradore
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Feedback extends Model
{
    
    static $rules = [
		'id_transmitter' => 'required',
		'id_receiver' => 'required',
		'feedback' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id_transmitter','id_receiver','feedback','status'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_receiver');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function colaboradore()
    {
        return $this->hasOne('App\Models\Colaboradore', 'id', 'id_transmitter');
    }
    

}
