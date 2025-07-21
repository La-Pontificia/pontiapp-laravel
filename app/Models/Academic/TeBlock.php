<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeBlock extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te_blo';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'name',
        'order',
        'categoryId',
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

    public function category()
    {
        return $this->belongsTo(TeCategory::class, 'categoryId', 'id');
    }

    public function questions()
    {
        return $this->hasMany(TeQuestion::class, 'blockId', 'id');
    }
}
