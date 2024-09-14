<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'business_units';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'acronym',
        'domain',
        'services',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'services' => 'array',
    ];

    static $rules = [
        'name' => 'required',
        'domain' => 'required',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
