<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasUuids;

    protected $table = 'user_jobs';

    protected $perPage = 20;

    protected $fillable = [
        'codePrefix',
        'level',
        'name',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function roles()
    {
        return $this->hasMany(Role::class, 'jobId', 'id');
    }

    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }
}
