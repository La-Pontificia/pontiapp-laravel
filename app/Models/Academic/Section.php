<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_sections';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'code',
        'planId',
        'periodId',
        'programId',
        'cycleId',
        'created_at',
        'updated_at',
        'creatorId',
        'updaterId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id', 'periodId');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id', 'programId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function cycle()
    {
        return $this->hasOne(Cycle::class, 'id', 'cycleId');
    }

    public function plan()
    {
        return $this->hasOne(plan::class, 'id', 'planId');
    }
}
