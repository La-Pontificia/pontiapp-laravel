<?php

namespace App\Models\Academic;

use App\Models\rm\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tevaluation extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'groupId',
        'sectionCourseId',
        'teacherId',
        'scheduleId',
        'evaluationNumber',
        'trackingTime',
        'branchId',
        'evaluatorId',
        'creatorId',
        'updaterId',
    ];

    public function group()
    {
        return $this->belongsTo(TeGroup::class, 'groupId', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }

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

    public function answers()
    {
        return $this->hasMany(TeAnswer::class, 'teId', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branchId', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacherId', 'id');
    }
}
