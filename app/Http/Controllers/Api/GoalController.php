<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Goal;
use App\Models\GoalEvaluation;
use Illuminate\Http\Request;

class GoalController extends Controller
{



    public function createGoals($goals, $eda)
    {
        foreach ($goals as $goal) {
            $goal = Goal::create([
                'id_eda' => $eda->id,
                'goal' => $goal['goal'],
                'description' => $goal['description'],
                'indicators' => $goal['indicators'],
                'percentage' => $goal['percentage'],
                'created_by' => auth()->user()->id,
            ]);

            $evaluations = $eda->evaluations;
            foreach ($evaluations as $evaluation) {
                GoalEvaluation::create([
                    'id_goal' => $goal->id,
                    'id_evaluation' => $evaluation->id,
                ]);
            }
        }
    }

    public function sent(Request $request)
    {
        $bodyRule = [
            'id_eda' => ['required', 'uuid', 'max:36'],
            'goals_to_create' => ['required', 'array'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $eda = Eda::find($request->id_eda);

        if (!$eda) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $goals = $request->goals_to_create;

        $rulePerGoal = [
            'goal' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:2000'],
            'indicators' => ['required', 'string', 'max:2000'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ];

        // validate each goal
        foreach ($goals as $goal) {
            $validator = validator($goal, $rulePerGoal);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }

        $this->createGoals($goals, $eda);

        $eda->sent = new \DateTime();
        $eda->save();

        return response()->json(['message' => 'Goals created successfully'], 201);
    }

    public function byEda($id)
    {
        $goals = Goal::where('id_eda', $id)->get();

        $goals = $goals->map(function ($goal) {
            $updatedBy = $goal->updatedBy()->select('id', 'first_name', 'last_name', 'profile')->first();
            $goal->updated_by = $updatedBy ? [
                'id' => $updatedBy->id,
                'full_name' => $updatedBy->first_name . ' ' . $updatedBy->last_name,
                'profile' => $updatedBy->profile,
            ] : null;

            $createdBy = $goal->createdBy()->select('id', 'first_name', 'last_name', 'profile')->first();
            $goal->created_by = $createdBy ? [
                'id' => $createdBy->id,
                'full_name' => $createdBy->first_name . ' ' . $createdBy->last_name,
                'profile' => $createdBy->profile,
            ] : null;

            return $goal;
        });

        return response()->json($goals, 200);
    }

    public function update(Request $request)
    {
        $bodyRule = [
            'id_eda' => ['required', 'uuid', 'max:36'],
            'goals_to_create' => ['array'],
            'goals_to_update' => ['array'],
            'goals_to_delete' => ['array'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $eda = Eda::find($request->id_eda);

        if (!$eda) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $goals_to_create = $request->goals_to_create;
        $goals_to_update = $request->goals_to_update;
        $goals_to_delete = $request->goals_to_delete;

        $rulePerGoal = [
            'goal' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:2000'],
            'indicators' => ['required', 'string', 'max:2000'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ];

        if ($goals_to_create) {
            foreach ($goals_to_create as $goal) {
                $validator = validator($goal, $rulePerGoal);
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 400);
                }
            }
        }

        if ($goals_to_update) {
            foreach ($goals_to_update as $goal) {
                $validator = validator($goal, $rulePerGoal);
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 400);
                }
            }
        }

        // delete each goal
        if ($goals_to_delete) {
            foreach ($goals_to_delete as $goalId) {
                $goal = Goal::find($goalId);
                if ($goal) {
                    $goal->delete();
                }
            }
        }

        // create each goal
        if ($goals_to_create) {
            $this->createGoals($goals_to_create, $eda);
        }

        // update each goal
        if ($goals_to_update) {
            foreach ($goals_to_update as $goal) {
                $goalToUpdate = Goal::find($goal['id']);

                $hasBeenEdited = $goalToUpdate->goal !== $goal['goal'] ||
                    $goalToUpdate->description !== $goal['description'] ||
                    $goalToUpdate->indicators !== $goal['indicators'] ||
                    $goalToUpdate->percentage !== $goal['percentage'];

                if ($goalToUpdate && $hasBeenEdited) {
                    $goalToUpdate->goal = $goal['goal'];
                    $goalToUpdate->description = $goal['description'];
                    $goalToUpdate->indicators = $goal['indicators'];
                    $goalToUpdate->percentage = $goal['percentage'];
                    $goalToUpdate->updated_by = auth()->user()->id;
                    $goalToUpdate->save();
                }
            }
        }

        return response()->json(['message' => 'Goals updated successfully'], 201);
    }

    public function approve(Request $request)
    {
        $bodyRule = [
            'id_eda' => ['required', 'uuid', 'max:36'],
        ];

        $bodyValidator = validator($request->all(), $bodyRule);

        if ($bodyValidator->fails()) {
            return response()->json(['error' => $bodyValidator->errors()], 400);
        }

        $eda = Eda::find($request->id_eda);

        if (!$eda) {
            return response()->json(['error' => 'Eda not found'], 404);
        }

        $eda->approved = new \DateTime();
        $eda->approved_by = auth()->user()->id;
        $eda->save();

        return response()->json(['message' => 'Goals approved successfully'], 200);
    }

    public function byEvaluation($id)
    {
        $goalsEvaluations = GoalEvaluation::where('id_evaluation', $id)->get();

        $items = $goalsEvaluations->map(function ($item) {
            $item->goal = $item->goal()->select('id', 'goal', 'description', 'indicators', 'percentage')->first();
            $item->evaluation = $item->evaluation;
            $item->self_rated_by = $item->selfRatedBy()->select('id', 'first_name', 'last_name', 'profile')->first();
            $item->average_by = $item->averagedBy()->select('id', 'first_name', 'last_name', 'profile')->first();
            return $item;
        });

        return response()->json($items, 200);
    }
}
