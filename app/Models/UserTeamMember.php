<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserTeamMember extends Model
{
    use HasUuids;

    protected $table = 'user_team_members';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'userId',
        'userTeamId',
        'role'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public function group()
    {
        return $this->hasOne(UserTeam::class, 'id', 'userTeamId');
    }
}
