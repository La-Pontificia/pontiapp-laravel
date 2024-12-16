<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    use HasUuids;

    protected $table = 'user_departments';

    protected $perPage = 20;

    protected $fillable = ['codePrefix', 'name', 'areaId'];
    protected $keyType = 'string';
    public $incrementing = false;


    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'areaId');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'departmentId', 'id');
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
