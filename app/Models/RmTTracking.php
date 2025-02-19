<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmTTracking extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rm_t_trackings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'teacherDocumentId',
        'teacherFullName',
        'period',
        'cycle',
        'section',
        'classRoom',
        'branchId',
        'businessUnitId',
        'area',
        'academicProgram',
        'course',
        'date',
        'evaluatorId',
        'evaluationNumber',
        'startOfClass',
        'endOfClass',
        'trackingTime',
        'er1Json',
        'er1a',
        'er1b',
        'er1Obtained',
        'er1Qualification',
        'er2Json',
        'er2a1',
        'er2a2',
        'er2aObtained',
        'er2b1',
        'er2b2',
        'er2bObtained',
        'er2Total',
        'er2FinalGrade',
        'er2Qualification',
        'aditional1',
        'aditional2',
        'aditional3',
    ];

    protected $casts = [
        'date' => 'date',
        'trackingTime' => 'date',
        'er1Json' => 'array',
        'er2Json' => 'array',
    ];

    public function evaluator()
    {
        return $this->hasOne(User::class, 'id', 'evaluatorId');
    }

    public function businessUnit()
    {
        return $this->hasOne(RmBusinessUnit::class, 'id', 'businessUnitId');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branchId');
    }
}
