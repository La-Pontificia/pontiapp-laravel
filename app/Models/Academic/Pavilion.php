<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pavilion extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_pavilions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'periodId',
        'created_at',
        'updated_at',
        'creatorId',
        'updaterId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id', 'periodId');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'pavilionId', 'id');
    }
}
