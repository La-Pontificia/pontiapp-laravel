<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceEmp extends Model
{
    use HasFactory;

    protected $table = 'personnel_employee';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'department_id',
    ];

    public function department()
    {
        return $this->hasOne(AttendanceDept::class, 'department_id', 'id');
    }
}
