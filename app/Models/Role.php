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
        'id_department' => 'required',
        'id_job_position' => 'required',
    ];

    protected $perPage = 25;

    protected $fillable = ['id', 'code', 'name', 'id_department', 'id_job_position'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'id_department');
    }

    public function job_position()
    {
        return $this->hasOne('App\Models\JobPosition', 'id', 'id_job_position');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'updated_by', 'id');
    }
}
