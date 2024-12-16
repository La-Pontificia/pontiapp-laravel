<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'users_notificitions';

    protected $perPage = 5;

    protected $fillable = [
        'toId',
        'title',
        'description',
        'creatorId',
        'read',
        'URL'
    ];

    protected $casts = [
        'read' => 'datetime',
    ];

    public function to()
    {
        return $this->hasOne(User::class, 'id', 'toId');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }
}
