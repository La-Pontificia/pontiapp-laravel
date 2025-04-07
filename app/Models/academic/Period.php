<?php

namespace App\Models\Academic;

use App\Models\rm\BusinessUnit;
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
        'businessUnitId',
        'creatorId',
        'updaterId',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, 'businessUnitId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }
}
