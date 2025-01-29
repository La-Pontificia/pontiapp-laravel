<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RmTTracking extends Model
{
    protected $table = 'rm_t_trackings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'teacherUserId',
        'teacherDocumentId',
        'teacherFullName',
        'semester',
        'semesterId',
        'cycle',
        'cycleId',
        'section',
        'sectionId',
        'classRoom',
        'classRomId',
        'headquarter',
        'headquarterId',
        'businessUnitId',
        'area',
        'areaId',
        'program',
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
        'erTotal',
        'erFinalGrade',
        'erQualification',
        'aditional1',
        'aditional2',
        'aditional3',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date',
        'er1Json' => 'array',
        'er2Json' => 'array',
        'evaluationNumber' => 'integer',
        'er1a' => 'integer',
        'er1b' => 'integer',
        'er1Obtained' => 'integer',
        'er2a1' => 'integer',
        'er2a2' => 'integer',
        'er2aObtained' => 'integer',
        'er2b1' => 'integer',
        'er2b2' => 'integer',
        'er2bObtained' => 'integer',
        'erTotal' => 'integer',
        'erFinalGrade' => 'integer',
    ];
}
