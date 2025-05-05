<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasUuids;

    protected $table = 'user_teams_members';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'userId',
        'teamId',
        'type',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
