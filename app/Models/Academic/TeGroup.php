<?php

namespace App\Models\Academic;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeGroup extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'academic_te_gro';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'name',
        'creatorId',
        'updaterId',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updaterId', 'id');
    }

    public function categories()
    {
        return $this->hasMany(TeCategory::class, 'groupId', 'id');
    }

    /**
     * Obtiene preguntas de tipo 'select' relacionadas al grupo.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function selectQuestions()
    {
        return TeQuestion::where('type', 'select')
            ->whereHas('block.category', fn($q) => $q->where('groupId', $this->id))
            ->get();
    }

    /**
     * Calcula el puntaje acumulado de opciones para cada pregunta,
     * seleccionando la opción según $order ('desc' para máximo, 'asc' para mínimo).
     *
     * @param string $order
     * @return float
     */
    protected function aggregateScore(string $order = 'desc'): float
    {
        $score = 0;

        $questions = $this->selectQuestions();

        foreach ($questions as $question) {
            $option = $question->options()
                ->orderBy('value', $order)
                ->first();

            if ($option) {
                $score += $option->value;
            }
        }

        return $score;
    }


    /**
     * Retorna la suma de los valores máximos por pregunta.
     *
     * @return float
     */
    public function highScore(): float
    {
        return $this->aggregateScore('desc');
    }

    /**
     * Retorna la suma de los valores mínimos por pregunta.
     *
     * @return float
     */
    public function lowScore(): float
    {
        return $this->aggregateScore('asc');
    }
}
