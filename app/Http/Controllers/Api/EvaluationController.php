<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\GoalEvaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{

    public function selfQualification(Request $request)
    {
        $bodyRule = [
            'id_evaluation' => ['required', 'uuid', 'max:36'],
            'items' => ['required', 'array'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $items = $request->items;

        $evaluation = Evaluation::find($request->id_evaluation);

        if (!$evaluation) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $rulePerItem = [
            'id' => ['required', 'uuid', 'max:36'],
            'self_qualification' => ['required', 'numeric', 'max:5', 'min:1'],
        ];

        // validate each goal
        foreach ($items as $item) {
            $validator = validator($item, $rulePerItem);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }

        // for each
        foreach ($items as $item) {
            $goalEvaluation = GoalEvaluation::find($item['id']);
            $goalEvaluation->self_qualification = $item['self_qualification'];
            $goalEvaluation->self_rated_at = now();
            $goalEvaluation->self_rated_by = auth()->user()->id;
            $goalEvaluation->save();
        }

        // total self qualification
        $totalSelfQualification = 0;

        foreach ($items as $item) {
            $ge = GoalEvaluation::find($item['id']);
            $note =  $item['self_qualification'] * ($ge->goal->percentage / 100);
            $totalSelfQualification += $note;
        }

        $evaluation->self_qualification = $totalSelfQualification;
        $evaluation->save();

        return response()->json(['message' => 'Self qualification saved'], 200);
    }

    public function average(Request $request)
    {
        $bodyRule = [
            'id_evaluation' => ['required', 'uuid', 'max:36'],
            'items' => ['required', 'array'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $items = $request->items;

        $evaluation = Evaluation::find($request->id_evaluation);

        if (!$evaluation) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $rulePerItem = [
            'id' => ['required', 'uuid', 'max:36'],
            'average' => ['required', 'numeric', 'max:5', 'min:1'],
        ];

        // validate each goal
        foreach ($items as $item) {
            $validator = validator($item, $rulePerItem);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }

        // for each
        foreach ($items as $item) {
            $goalEvaluation = GoalEvaluation::find($item['id']);
            $goalEvaluation->average = $item['average'];
            $goalEvaluation->averaged_at = now();
            $goalEvaluation->averaged_by = auth()->user()->id;
            $goalEvaluation->save();
        }

        // total average
        $totalAverage = 0;
        foreach ($items as $item) {
            $ge = GoalEvaluation::find($item['id']);
            $note =  $item['average'] * ($ge->goal->percentage / 100);
            $totalAverage += $note;
        }

        $evaluation->average = $totalAverage;
        $evaluation->save();

        return response()->json(['message' => 'Average saved'], 200);
    }

    public function close(Request $request)
    {

        $bodyRule = [
            'id_evaluation' => ['required', 'uuid', 'max:36'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $evaluation = Evaluation::find($request->id_evaluation);

        if (!$evaluation) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $evaluation->closed = now();
        $evaluation->closed_by = auth()->user()->id;
        $evaluation->save();

        return response()->json(['message' => 'Evaluation closed'], 200);
    }
}
