<?php

namespace App\Models\Academic;

use App\Models\Rm\BusinessUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_periods';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'startDate',
        'endDate',
        'creatorId',
        'updaterId',
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'periodId', 'id');
    }

    public function pavilions()
    {
        return $this->hasMany(Pavilion::class, 'periodId', 'id');
    }
}
