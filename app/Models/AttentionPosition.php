<?php

namespace App\Models;

use App\Models\Rm\BusinessUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttentionPosition extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'attentions_positions';

    protected $perPage = 30;

    protected $fillable = [
        'name',
        'businessUnitId',
        'available',
        'shortName',
        'creatorId',
        'updaterId',
        'currentUserId',
        'ui',
        'background'
    ];

    protected $casts = [
        'available' => 'boolean',
        'ui' => 'array'
    ];


    public function business()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'businessUnitId');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function current()
    {
        return $this->hasOne(User::class, 'id', 'currentUserId');
    }
}
