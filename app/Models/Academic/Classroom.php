<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_classrooms';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'code',
        'typeId',
        'capacity',
        'floor',
        'pavilionId',
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

    public function pavilion()
    {
        return $this->hasOne(Pavilion::class, 'id', 'pavilionId');
    }

    public function type()
    {
        return $this->hasOne(ClassType::class, 'id', 'typeId');
    }

    public function businessUnits()
    {
        return $this->hasMany(ClassroomBusiness::class, 'academicClassroomId', 'id');
    }

    public function businessUnitPontisisCode($businessUnitId)
    {
        $business = $this->businessUnits()->where('businessUnitId', $businessUnitId)->first();
        return $business ? $business->pontisisCode : null;
    }
}
