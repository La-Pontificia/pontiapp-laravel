<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmPeriod extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'rm_periods';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'academicProgramId',
        'creatorId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function academicProgram()
    {
        return $this->hasOne(RmAcademicProgram::class, 'id', 'academicProgramId');
    }
}
