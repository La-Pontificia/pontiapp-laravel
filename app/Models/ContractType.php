<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'contract_types';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'contract_id', 'id');
    }
}
