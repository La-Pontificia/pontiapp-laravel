<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCourse extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_section_courses';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'sectionId',
        'planCourseId',
        'teacherId',
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

    public function section()
    {
        return $this->hasOne(Section::class, 'id', 'sectionId');
    }

    public function planCourse()
    {
        return $this->hasOne(PlanCourse::class, 'id', 'planCourseId');
    }

    public function teacher()
    {
        return $this->hasOne(User::class, 'id', 'teacherId');
    }

    public function schedules()
    {
        return $this->hasMany(SectionCourseSchedule::class, 'sectionCourseId', 'id');
    }
}
