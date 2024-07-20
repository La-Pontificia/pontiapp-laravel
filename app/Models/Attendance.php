<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use HasFactory;

    protected $table = 'iclock_transaction';

    protected $perPage = 20;

    protected $fillable = [
        'id',
        'punch_time',
        'emp_code',
        'area_alias',
        'emp_id',
    ];

    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    public function getUserFromMysql()
    {
        return User::on('mysql')->where('dni', $this->emp_code)->first();
    }

    public function employee()
    {
        return $this->belongsTo(AttendanceEmp::class, 'emp_id', 'id');
    }
}
