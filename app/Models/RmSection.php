<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmSection extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'rm_sections';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'periodId',
        'name',
        'creatorId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function period()
    {
        return $this->hasOne(RmPeriod::class, 'id', 'periodId');
    }
}
