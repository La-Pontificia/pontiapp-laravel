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
        'email',
        'password',
        'id_role_user',
        'privileges',
        'status',
        'id_role',
        'id_branch',
        'group_schedule_id',
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
        'username' => 'required',
        'domain' => 'required',
        'last_name' => 'required',
        'id_role' => ['required', 'max:36'],
        'id_role_user' => ['required', 'uuid'],
        'id_branch' => ['required', 'uuid'],
        'group_schedule_id' => ['uuid'],
    ];


    public function role_position()
    {
        return $this->hasOne(Role::class, 'id', 'id_role');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'id_branch');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'id_user', 'id');
    }

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'id_role_user');
    }

    public function hasPrivilege($key)
    {
        return in_array($key, $this->role->privileges);
    }

    public function groupSchedule()
    {
        return $this->hasOne(GroupSchedule::class, 'id', 'group_schedule_id');
    }
}
