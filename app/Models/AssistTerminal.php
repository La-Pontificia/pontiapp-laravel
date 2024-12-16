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
        'databaseName',
        'created_by',
        'updated_by',
    ];

    static $rules = [
        'name' => 'required',
        'database_name' => 'required',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function createdUser()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function updatedUser()
    {
        return $this->hasOne(User::class, 'id', 'updatedBy');
    }
}
