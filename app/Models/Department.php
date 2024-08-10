<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    use HasUuids;

    protected $table = 'departments';

    static $rules = [
        'name' => 'required',
        'id_area' => 'required',
    ];

    protected $perPage = 20;

    protected $fillable = ['code', 'name', 'id_area'];
    protected $keyType = 'string';
    public $incrementing = false;


    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'id_area');
    }

    public function job_positions()
    {
        return $this->hasMany(JobPosition::class, 'id_department', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }
}
