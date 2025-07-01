<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanCourse extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_plan_courses';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'planId',
        'courseId',
        'cycleId',
        'formula',
        'credits',
        'teoricHours',
        'practiceHours',
        'status',
        'creatorId',
        'updaterId',
        'created_at',
        'updated_at',
    ];

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'courseId');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'planId');
    }

    public function cycle()
    {
        return $this->hasOne(Cycle::class, 'id', 'cycleId');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }
}
