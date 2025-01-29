<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdaObjetive extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'edas_objetives';

    protected $perPage = 20;

    protected $fillable = [
        'edaId',
        'title',
        'order',
        'description',
        'indicators',
        'percentage',
        'creatorId',
        'updaterId',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function eda()
    {
        return $this->hasOne(Eda::class, 'id', 'edaId');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }
}
