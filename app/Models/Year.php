<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasUuids;

    static $rules = [
        'name' => ['required', 'string', 'max:255'],
        'status' => ['required', 'boolean'],
    ];

    protected $table = 'years';

    protected $perPage = 20;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'status'];
}
