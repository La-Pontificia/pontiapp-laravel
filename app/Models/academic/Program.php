<?php

namespace App\Models\Academic;

use App\Models\rm\BusinessUnit;
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
        'businessUnitId',
        'creatorId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'businessUnitId');
    }
}
