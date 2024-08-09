<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class QuestionnaireTemplate extends Model
{

  use HasUuids;

  protected $table = 'questionnaire_templates';

  protected $perPage = 20;

  protected $fillable = [
    'title',
    'for',
    'in_use',
    'archived'
  ];

  protected $keyType = 'string';

  public $incrementing = false;

  public function questions()
  {
    return $this->hasMany(Question::class, 'template_id', 'id');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by', 'id');
  }
}
