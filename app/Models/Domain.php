<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'domains';

    protected $fillable = [
        'id',
        'domain',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    static $rules = [
        'domain' => ['required', 'string', 'max:255'],
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
    public function updatedBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
