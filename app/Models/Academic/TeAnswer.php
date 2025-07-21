<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeAnswer extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te_ans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'answer',
        'teId',
        'questionId',
    ];

    public function question()
    {
        return $this->belongsTo(TeQuestion::class, 'questionId', 'id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Tevaluation::class, 'teId', 'id');
    }
}
