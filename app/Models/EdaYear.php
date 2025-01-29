<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EdaYear extends Model
{
    use HasUuids;

    protected $table = 'edas_years';

    protected $perPage = 20;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'status', 'creatorId', 'updaterId'];

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }
}
