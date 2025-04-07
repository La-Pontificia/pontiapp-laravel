<?php

namespace App\Models\Academic;

use App\Models\Rm\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTracking extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_teacher_trackings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'sectionCourseId',
        'scheduleId',
        'branchId',
        'date',
        'trackingTime',
        'evaluatorId',
        'evaluationNumber',

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
        'trackingTime' => 'datetime',
        'er1Json' => 'array',
        'er2Json' => 'array',
    ];

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluatorId', 'id');
    }

    public function sectionCourse()
    {
        return $this->belongsTo(SectionCourse::class, 'sectionCourseId', 'id');
    }

    public function schedule()
    {
        return $this->belongsTo(SectionCourseSchedule::class, 'scheduleId', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branchId', 'id');
    }
}
