<?php

namespace App\Models\Academic;

use App\Models\Rm\BusinessUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomBusiness extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_classroom_bc';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'pontisisCode',
        'businessUnitId',
        'academicClassroomId',
        'created_at',
        'updated_at',
    ];

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'businessUnitId');
    }

    public function academicClassroom()
    {
        return $this->hasOne(Classroom::class, 'id', 'academicClassroomId');
    }
}
