<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmBusinessUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rm_business_units';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'acronym',
        'logoURL',
        'domain',
        'creatorId',
        'updaterId',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }
}
