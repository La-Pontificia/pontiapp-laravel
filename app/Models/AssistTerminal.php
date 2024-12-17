<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistTerminal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'assist_terminals';

    protected $perPage = 20;

    protected $fillable = [
        'name',
        'database',
        'created_by',
        'updated_by',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }

    public function schedulesCount()
    {
        return $this->hasMany(Schedule::class, 'assistTerminalId', 'id')->count();
    }
}
