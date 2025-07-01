<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_courses';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'code',
        'name',
        'businessUnitId',
        'teoricHours',
        'practiceHours',
        'credits',
        'creatorId',
        'updaterId',
        'created_at',
        'updated_at',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function getHoursNameAttribute()
    {
        return ($this->teoricHours  ?? 0) . 'TE+' . ($this->practiceHours ?? 0) . 'LA';
    }
}
