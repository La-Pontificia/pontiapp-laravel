<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAudit extends Model
{
    use HasUuids, HasFactory;


    protected $table = 'user_audits';

    protected $perPage = 20;

    protected $fillable = [
        'userId',
        'data', // <--- this is a json field
        'key',
        'creatorId'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId');
    }
}
