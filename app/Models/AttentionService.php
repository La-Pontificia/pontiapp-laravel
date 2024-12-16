<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttentionService extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'attentions_services';

    protected $perPage = 30;

    protected $fillable = [
        'name',
        'attentionPositionId',
        'creatorId',
        'updaterId',
    ];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function position()
    {
        return $this->hasOne(AttentionPosition::class, 'id', 'attentionPositionId');
    }
}
