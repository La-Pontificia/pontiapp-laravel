<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasUuids;

    protected $table = 'roles';

    static $rules = [
        'name' => 'required',
        'departmentId' => 'required',
        'jobId' => 'required',
    ];

    protected $perPage = 20;

    protected $fillable = ['id', 'codePrefix', 'name', 'departmentId', 'jobId'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function users()
    {
        return $this->hasMany(User::class, 'roleId', 'id');
    }

    public function isDev()
    {
        return $this->id === '9b342044-7a95-4b10-b19f-cc968516b81e';
    }

    public function usersCount()
    {
        return $this->hasMany(User::class, 'roleId', 'id')->count();
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'departmentId');
    }

    public function job()
    {
        return $this->hasOne(Job::class, 'id', 'jobId');
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
