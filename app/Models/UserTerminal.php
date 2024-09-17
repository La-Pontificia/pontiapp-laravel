<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTerminal extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'user_assist_terminal';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'user_id',
        'assist_terminal_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function assistTerminal()
    {
        return $this->hasOne(AssistTerminal::class, 'id', 'assist_terminal_id');
    }
}
