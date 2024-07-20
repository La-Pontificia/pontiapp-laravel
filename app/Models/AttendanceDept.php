<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDept extends Model
{
    use HasFactory;

    protected $table = 'personnel_department';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'dept_name',
    ];
}
