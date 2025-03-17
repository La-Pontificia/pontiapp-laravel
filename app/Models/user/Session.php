<?php

namespace App\Models\user;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'user_sessions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $paginate = 10;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'userId',
        'ip',
        'userAgent',
        'location',
        'isMobile',
        'isTablet',
        'isDesktop',
        'browser',
        'platform',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
