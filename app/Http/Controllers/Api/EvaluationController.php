<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\GoalEvaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{

    public function selfqualify(Request $request, $id)
    {

        $request->validate([
            'items' => 'required|array',
        ]);

        $items = $request->items;
        $evaluation = Evaluation::find($id);

        if (!$evaluation) return response()->json('Evaluatión not found', 404);

        $rulePerItem = [
            'id' => ['required', 'uuid', 'max:36'],
            'self_qualification' => ['required', 'numeric', 'max:5', 'min:1'],
        ];

        foreach ($items as $item) {
            $validator = validator($item, $rulePerItem);
            if ($validator->fails())  return response()->json($validator->errors()->first(), 400);
        }

        foreach ($items as $item) {
            $goalEvaluation = GoalEvaluation::find($item['id']);
            $goalEvaluation->self_qualification = $item['self_qualification'];
            $goalEvaluation->save();
        }

        $totalSelfQualification = 0;

        foreach ($items as $item) {
            $ge = GoalEvaluation::find($item['id']);
            $note =  $item['self_qualification'] * ($ge->goal->percentage / 100);
            $totalSelfQualification += $note;
        }

        $evaluation->self_qualification = $totalSelfQualification;
        $evaluation->self_rated_at = now();
        $evaluation->self_rated_by = auth()->user()->id;
        $evaluation->save();

        return response()->json('Objetivos autocalificados correctamente.', 200);
    }

    public function qualify(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        $items = $request->items;
        $evaluation = Evaluation::find($id);

        if (!$evaluation) return response()->json('Evaluatión not found', 404);

        $rulePerItem = [
            'id' => ['required', 'uuid', 'max:36'],
            'qualification' => ['required', 'numeric', 'max:5', 'min:1'],
        ];

        foreach ($items as $item) {
            $validator = validator($item, $rulePerItem);
            if ($validator->fails())  return response()->json($validator->errors()->first(), 400);
        }

        foreach ($items as $item) {
            $goalEvaluation = GoalEvaluation::find($item['id']);
            $goalEvaluation->qualification = $item['qualification'];
            $goalEvaluation->save();
        }

        // total average
        $totalQualify = 0;
        foreach ($items as $item) {
            $ge = GoalEvaluation::find($item['id']);
            $note =  $item['qualification'] * ($ge->goal->percentage / 100);
            $totalQualify += $note;
        }

        $evaluation->qualification = $totalQualify;
        $evaluation->qualified_at = now();
        $evaluation->qualified_by = auth()->user()->id;
        $evaluation->save();

        return response()->json('Objetivos calificados correctamente.', 200);
    }

    public function close($id)
    {

        $evaluation = Evaluation::find($id);

        if (!$evaluation)
            return response()->json('Eda not found', 404);

        $evaluation->closed = now();
        $evaluation->closed_by = auth()->user()->id;
        $evaluation->save();

        return response()->json('Evaluación cerrada correctamente', 200);
    }
}
