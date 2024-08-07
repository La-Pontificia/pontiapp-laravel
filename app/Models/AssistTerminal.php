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
        'database_name',
        'created_by',
        'updated_by',
    ];

    static $rules = [
        'name' => 'required',
        'database_name' => 'required',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
