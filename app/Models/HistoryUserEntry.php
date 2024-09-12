<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryUserEntry extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'history_user_entries';

    protected $perPage = 20;

    protected $fillable = [
        'user_id',
        'entry_date',
        'exit_date',
        'created_by',
    ];

    protected $keyType = 'string';
    public $incrementing = false;


    protected $casts = [
        'entry_date' => 'date',
        'exit_date' => 'date',
    ];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }


    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
