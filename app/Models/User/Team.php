<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasUuids;

    protected $table = 'user_teams';

    protected $fillable = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];


    public function members()
    {
        return $this->hasMany(TeamMember::class, 'teamId', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }
}
