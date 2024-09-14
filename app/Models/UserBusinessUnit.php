<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBusinessUnit extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'user_business_units';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'user_id',
        'business_unit_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'business_unit_id');
    }
}
