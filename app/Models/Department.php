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
        return $this->hasOne('App\Models\Area', 'id', 'id_area');
    }

    public function job_positions()
    {
        return $this->hasMany('App\Models\JobPosition', 'id_department', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
