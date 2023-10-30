<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Eda
 *
 * @property $id
 * @property $year
 * @property $n_evaluacion
 * @property $f_inicio
 * @property $f_fin
 * @property $wearing
 * @property $created_at
 * @property $updated_at
 *
 * @property EdaColab[] $edaColabs
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Eda extends Model
{

  static $rules = [
    'year' => 'required',
    'n_evaluacion' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['year', 'n_evaluacion',  'wearing'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function edaColabs()
  {
    return $this->hasMany('App\Models\EdaColab', 'id_eda', 'id');
  }
}
