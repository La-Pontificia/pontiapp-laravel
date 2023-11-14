<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Plantilla
 *
 * @property $id
 * @property $nombre
 * @property $para
 * @property $created_at
 * @property $updated_at
 *
 * @property PlantillaPreguntum[] $plantillaPreguntas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Plantilla extends Model
{

  static $rules = [
    'nombre' => 'required',
    'para' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['nombre', 'para'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function plantillaPreguntas()
  {
    return $this->hasMany('App\Models\PlantillaPreguntum', 'id_plantilla', 'id');
  }
}
