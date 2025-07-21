<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeCategory extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te_cat';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'name',
        'order',
        'groupId',
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

    public function group()
    {
        return $this->belongsTo(TeGroup::class, 'groupId', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(TeBlock::class, 'categoryId', 'id');
    }
}
