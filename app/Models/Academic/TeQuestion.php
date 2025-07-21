<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te_que';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'question',
        'order',
        'blockId',
        'type',
        'creatorId',
        'updaterId',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }

    public function block()
    {
        return $this->belongsTo(TeBlock::class, 'blockId', 'id');
    }

    public function options()
    {
        return $this->hasMany(TeOption::class, 'questionId', 'id');
    }
}
