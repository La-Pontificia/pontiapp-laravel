<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Eda extends Model
{
  use HasUuids;

  protected $table = 'edas';

  protected $perPage = 20;

  protected $fillable = [
    'userId',
    'approverId',
    'closerId',
    'senderId',
    'approvedAt',
    'closedAt',
    'sentAt',
    'managedId',
    'yearId',
    'creatorId'
  ];

  protected $keyType = 'string';
  public $incrementing = false;

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'userId');
  }

  public function creator()
  {
    return $this->hasOne(User::class, 'id', 'creatorId');
  }

  public function approver()
  {
    return $this->hasOne(User::class, 'id', 'approverId');
  }

  public function closer()
  {
    return $this->hasOne(User::class, 'id', 'closerId');
  }

  public function sender()
  {
    return $this->hasOne(User::class, 'id', 'senderId');
  }

  public function year()
  {
    return $this->hasOne(EdaYear::class, 'id', 'yearId');
  }

  public function managed()
  {
    return $this->hasOne(User::class, 'id', 'managedId');
  }

  public function evaluations()
  {
    return $this->hasMany(EdaEvaluation::class, 'edaId', 'id');
  }

  public function objetives()
  {
    return $this->hasMany(EdaObjetive::class, 'edaId', 'id');
  }
}
