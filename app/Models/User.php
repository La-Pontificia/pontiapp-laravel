<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $table = 'users';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'profile',
        'dni',
        'first_name',
        'last_name',
        'password',
        'id_role_user',
        'privileges',
        'status',
        'id_role',
        'id_branch',
        'created_by',
        'updated_by',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static $rules = [
        'dni' => 'required|numeric|digits:8',
        'first_name' => 'required',
        'last_name' => 'required',
        'id_role' => ['required', 'max:36'],
        'id_role_user' => ['required', 'uuid'],
        'id_branch' => ['required', 'uuid'],
    ];



    public function role_position()
    {
        return $this->hasOne('App\Models\Role', 'id', 'id_role');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'id_branch');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    public function emails()
    {
        return $this->hasMany('App\Models\Email', 'id_user', 'id');
    }

    public function email()
    {
        return $this->emails()->first()->email;
    }

    public function role()
    {
        return $this->hasOne('App\Models\UserRole', 'id', 'id_role_user');
    }

    public function hasPrivilege($key)
    {
        return in_array($key, $this->role->privileges);
    }
}
