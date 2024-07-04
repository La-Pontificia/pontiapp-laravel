<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $table = 'users';

    protected $perPage = 20;

    protected $fillable = [
        'profile',
        'dni',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'privileges',
        'status',
        'id_role',
        'id_branch',
        'created_by',
        'updated_by',
        'id_supervisor',
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
        'id_role' => ['required', 'string', 'max:36'],
        'role' => 'required',
        'id_branch' => ['required', 'string', 'max:36'],
        'email' => 'required|email',
    ];

    public function hasPrivilege($key)
    {
        $userPrivileges = json_decode($this->privileges, true);
        return in_array($key, $userPrivileges);
    }

    public function hasDevelperPrivilege()
    {
        return $this->role === 'dev';
    }

    public function supervisor()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_supervisor');
    }

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
}
