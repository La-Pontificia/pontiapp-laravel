<?php

namespace App\Models\Academic;

use App\Models\Rm\BusinessUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_programs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'acronym',
        'businessUnitId',
        'creatorId',
        'areaId'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class, 'businessUnitId', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'areaId', 'id');
    }
}
