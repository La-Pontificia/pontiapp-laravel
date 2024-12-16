<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketModule extends Model
{
    use HasUuids, HasFactory;


    protected $table = 'tickets_modules';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'number',
        'state',
        'business_id',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function business()
    {
        return $this->hasOne(TicketBusinessUnit::class, 'id', 'business_id');
    }
}
