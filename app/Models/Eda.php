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
    'approvedId',
    'closedId',
    'sentId',
    'status',
    'approvedAt',
    'closedAt',
    'sentAt',
    'year',
    'creatorId'
  ];

  protected $keyType = 'string';
  public $incrementing = false;
}
