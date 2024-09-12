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
    ];

    protected $fillable = [
        'id',
        'title',
        'privileges',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'privileges' => 'array',
    ];

    public function isDev()
    {
        return $this->id === '9cb63cf0-f278-44f4-9f66-93c13bbb4e82';
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_role_user', 'id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
