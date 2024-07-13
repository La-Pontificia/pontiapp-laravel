<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'collaborators';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'id_user',
        'create_by',
        'supervised_by',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function supervisedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'supervised_by');
    }
}
