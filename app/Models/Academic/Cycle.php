<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'academic_cycles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'programId',
        'code',
        'name',
        'created_at',
        'updated_at',
        'creatorId',
        'updaterId',
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creatorId');
    }

    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updaterId');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id', 'programId');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'cycleId', 'id');
    }

    public function displayName()
    {
        $codes = [
            'I' => '01.- Primero',
            'II' => '02.- Segundo',
            'III' => '03.- Tercero',
            'IV' => '04.- Cuarto',
            'V' => '05.- Quinto',
            'VI' => '06.- Sexto',
            'VII' => '07.- Séptimo',
            'VIII' => '08.- Octavo',
            'IX' => '09.- Noveno',
            'X' => '10.- Décimo',
        ];

        return $codes[$this->code] ?? $this->name;
    }
}
