<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'audit';

    protected $perPage = 20;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'module',
        'path',
        'os',
        'ip',
        'browser',
        'device',
        'platform',
        'country',
        'region',
        'city',
        'action'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
