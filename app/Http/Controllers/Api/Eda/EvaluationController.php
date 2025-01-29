<?php

namespace App\Http\Controllers\Api\Eda;

use App\Http\Controllers\Controller;
use App\Models\EdaEvaluation;
use App\Models\EdaEvaluationObjetive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController  extends Controller
{
    public function slug(Request $req, $slug)
    {
        $includes = explode(',', $req->query('relationship'));
        $evaluation = EdaEvaluation::find($slug);
        return response()->json(
            $evaluation->only(['id', 'number', 'qualification', 'qualificationAt', 'selftQualification', 'selftQualificationAt', 'closedAt']) +
                [
                    'qualifier' => in_array('qualifier', $includes) ? $evaluation->qualifier?->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                    'selftQualifier' => in_array('selftQualifier', $includes) ? $evaluation->selftQualifier?->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                    'closer' => in_array('closer', $includes) ? $evaluation->closer?->only(['id', 'firstNames', 'lastNames', 'displayName', 'username', 'photoURL']) : null,
                    'objetives' => in_array('objetives', $includes) ? $evaluation->objetives?->map(function ($obj) {
                        return $obj->only(['id', 'qualification', 'selftQualification']) + [
                            'objetive' => $obj->objetive?->only(['id', 'title', 'description', 'indicators', 'percentage', 'order']),
                        ];
                    }) : null,
                ]
        );
    }

    public function qualify(Request $req, $slug)
    {
        $req->validate([
            'objetives' => 'required|array',
            'total' => 'required|numeric',
        ]);

        $objetives = collect($req->objetives)->map(function ($objetive) {
            return (object) $objetive;
        });

        foreach ($objetives as $objetive) {
            $evaluationObjetive = EdaEvaluationObjetive::find($objetive->id);
            $evaluationObjetive->qualification = $objetive->qualification;
            $evaluationObjetive->save();
        }

        $evaluation = EdaEvaluation::find($slug);
        $evaluation->qualification = $req->total;
        $evaluation->qualificationAt = now();
        $evaluation->qualifierId = Auth::id();
        $evaluation->save();
        return response()->json('Ok');
    }

    public function selftQualify(Request $req, $slug)
    {
        $req->validate([
            'objetives' => 'required|array',
            'total' => 'required|numeric',
        ]);

        $objetives = collect($req->objetives)->map(function ($objetive) {
            return (object) $objetive;
        });

        foreach ($objetives as $objetive) {
            $evaluationObjetive = EdaEvaluationObjetive::find($objetive->id);
            $evaluationObjetive->selftQualification = $objetive->selftQualification;
            $evaluationObjetive->save();
        }

        $evaluation = EdaEvaluation::find($slug);
        $evaluation->selftQualification = $req->total;
        $evaluation->selftQualificationAt = now();
        $evaluation->selftQualifierId = Auth::id();
        $evaluation->save();
        return response()->json('Ok');
    }

    public function close($slug)
    {
        $evaluation = EdaEvaluation::find($slug);
        $evaluation->closedAt = now();
        $evaluation->closerId = Auth::id();
        $evaluation->save();
        return response()->json('Ok');
    }
}
