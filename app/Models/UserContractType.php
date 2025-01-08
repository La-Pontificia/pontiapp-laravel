<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContractType extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'user_contract_types';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'description',
        'createdBy',
        'updatedBy',
    ];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'contractTypeId', 'id');
    }

    public function usersCount()
    {
        return $this->users()->count();
    }
}
