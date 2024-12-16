<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBusinessUnit extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'tickets_business_units';

    protected $perPage = 20;

    protected $fillable = [
        'business_unit_id',
    ];

    public function businessUnit()
    {
        return $this->hasOne(BusinessUnit::class, 'id', 'business_unit_id');
    }
}
