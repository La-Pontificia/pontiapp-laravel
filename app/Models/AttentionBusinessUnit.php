<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttentionBusinessUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'attentions_business_units';

    protected $perPage = 30;

    protected $fillable = [
        'businessUnitId',
    ];

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'businessUnitId');
    }
}
