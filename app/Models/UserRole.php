<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'user_roles';

    static $rules = [
        'title' => 'required|string|max:255',
        'level' => 'required|integer',
    ];

    protected $fillable = [
        'id',
        'title',
        'privileges',
        'status',
        'createdBy',
        'level',
        'updatedBy',
    ];

    protected $casts = [
        'privileges' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'userRoleId', 'id');
    }

    public function usersCount()
    {
        return $this->hasMany(User::class, 'userRoleId', 'id')->count();
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
