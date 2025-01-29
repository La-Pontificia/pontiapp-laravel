<?php

namespace App\Http\Controllers\Api\Eda;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\EdaEvaluation;
use App\Models\EdaEvaluationObjetive;
use App\Models\EdaObjetive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObjetiveController  extends Controller
{

    public function byEda(Request $req, $slug)
    {
        $match = EdaObjetive::where('edaId', $slug)->orderBy('order', 'asc');
        $includes = explode(',', $req->query('relationship'));
        $objetives = $match->get();

        return response()->json(
            $objetives->map(function ($objetive) use ($includes) {
                return $objetive->only(['id', 'title', 'description', 'indicators', 'percentage', 'order', 'created_at', 'updated_at']) + [
                    'eda' => in_array('eda', $includes) ? $objetive->eda->only(['id'] + [
                        'year' => in_array('eda.year', $includes) ? $objetive->eda->year->only(['id', 'name']) : null,
                    ]) : null,
                    'creator' => in_array('creator', $includes) ? $objetive->creator?->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                    'updater' => in_array('updater', $includes) ? $objetive->updater?->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                ];
            })
        );
    }

    public function storeByEda(Request $req, $slug)
    {
        $req->validate([
            'objetives' => 'required|array',
            'deleted' => 'array',
        ]);

        // delete objetives
        EdaObjetive::whereIn('id', $req->deleted)->delete();

        // convert to collection and object
        $objetives = collect($req->objetives)->map(function ($objetive) {
            return (object) $objetive;
        });
        // sorted by order
        $objetives = $objetives->sortBy('order')->values()->all();

        // validate percentage
        $totalPercentage = 0;
        foreach ($objetives as $objetive) {
            $totalPercentage += $objetive->percentage;
        }
        if ($totalPercentage !== 100) {
            return response()->json('La suma total de porcentaje tiene que ser 100%', 400);
        }

        $edaObjetives = EdaObjetive::where('edaId', $slug)->get();
        $edaEvaluations = EdaEvaluation::where('edaId', $slug)->get();

        foreach ($objetives as $objetive) {
            $alreadyExist = $edaObjetives->where('id', $objetive->id)->first();
            if ($alreadyExist) {
                $obj = EdaObjetive::find($objetive->id);
                $obj->title = $objetive->title;
                $obj->description = $objetive->description;
                $obj->indicators = $objetive->indicators;
                $obj->percentage = $objetive->percentage;
                $obj->order = $objetive->order;
                $obj->updaterId = Auth::id();
                $obj->save();
            } else {
                $obj = EdaObjetive::create([
                    'edaId' => $slug,
                    'title' => $objetive->title,
                    'description' => $objetive->description,
                    'indicators' => $objetive->indicators,
                    'percentage' => $objetive->percentage,
                    'order' => $objetive->order,
                    'creatorId' => Auth::id(),
                ]);

                $eva1 = $edaEvaluations->where('number', 1)->first();
                $eva2 = $edaEvaluations->where('number', 2)->first();

                EdaEvaluationObjetive::create([
                    'objetiveId' => $obj->id,
                    'evaluationId' => $eva1->id,
                ]);

                EdaEvaluationObjetive::create([
                    'objetiveId' => $obj->id,
                    'evaluationId' => $eva2->id,
                ]);
            }
        }

        Eda::find($slug)->update([
            'senderId' => Auth::id(),
            'sentAt' => now(),
        ]);

        return response()->json('ok');
    }
}
