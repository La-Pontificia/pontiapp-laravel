<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    use HasUuids;

    protected $table = 'user_teams';

    protected $fillable = [
        'id',
        'name',
        'photoURL',
        'description',
        'createdBy',
        'updatedBy',
    ];


    public function members()
    {
        return $this->hasMany(UserTeamMember::class, 'userTeamId', 'id')->with('user')->where('role', 'member');
    }

    public function membersCount()
    {
        return $this->hasMany(UserTeamMember::class, 'userTeamId', 'id')->where('role', 'member')->count();
    }

    public function owners()
    {
        return $this->hasMany(UserTeamMember::class, 'userTeamId', 'id')->with('user')->where('role', 'owner');
    }

    public function ownersCount()
    {
        return $this->hasMany(UserTeamMember::class, 'userTeamId', 'id')->where('role', 'owner')->count();
    }

    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }
}
