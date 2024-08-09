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
                'title' => $goal['title'],
                'comments' => $goal['comments'],
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

    public function sent(Request $request, $id)
    {

        $eda = Eda::find($id);

        if (!$eda) {
            return response()->json('Eda no encontrado', 404);
        }

        $request->validate([
            'goals' => ['required', 'array'],
        ]);

        $goals = $request->goals;

        $rulePerGoal = [
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:2000'],
            'indicators' => ['required', 'string', 'max:2000'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ];

        // validate each goal
        foreach ($goals as $goal) {
            $validator = validator($goal, $rulePerGoal);
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }
        }

        $this->createGoals($goals, $eda);

        $eda->sent = now();
        $eda->sent_by = auth()->user()->id;
        $eda->save();

        return response()->json('Objetivos enviados correctamente', 200);
    }

    public function byEda($id)
    {
        $goals = Goal::where('id_eda', $id)->get();

        $goals = $goals->map(function ($goal) {
            $goal->updatedBy = $goal->updatedBy ?  $goal->updatedBy->last_name . ', ' . $goal->updatedBy->first_name : null;
            $goal->createdBy = $goal->createdBy ? $goal->createdBy->last_name . ', ' . $goal->createdBy->first_name : null;
            return $goal;
        });

        return response()->json($goals, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'goals' => ['required', 'array'],
            'goals_to_delete' => ['array'],
        ]);

        $eda = Eda::find($id);

        if (!$eda)  return response()->json(['Eda not found'], 404);

        $rulePerGoal = [
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:2000'],
            'comments' => ['string', 'max:2000', 'nullable'],
            'indicators' => ['required', 'string', 'max:2000'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ];

        // validate each goal
        foreach ($request->goals as $goal) {
            $validator = validator($goal, $rulePerGoal);
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }
        }

        $goals_to_create = array_filter($request->goals, function ($goal) {
            return !isset($goal['id']) || $goal['id'] === null;
        });

        $goals_to_update = array_filter($request->goals, function ($goal) {
            return isset($goal['id']) && $goal['id'] !== null;
        });

        $goals_to_delete = $request->goals_to_delete;

        // delete each goal
        if ($goals_to_delete) {
            foreach ($goals_to_delete as $goalId) {
                $goal = Goal::find($goalId);
                if ($goal) {
                    $goal->evaluations()->delete();
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

                $hasBeenEdited = $goalToUpdate->title !== $goal['title'] ||
                    $goalToUpdate->description !== $goal['description'] ||
                    $goalToUpdate->indicators !== $goal['indicators'] ||
                    $goalToUpdate->percentage !== $goal['percentage'];
                $goalToUpdate->comments !== $goal['comments'];

                if ($goalToUpdate && $hasBeenEdited) {
                    $goalToUpdate->title = $goal['title'];
                    $goalToUpdate->description = $goal['description'];
                    $goalToUpdate->indicators = $goal['indicators'];
                    $goalToUpdate->percentage = $goal['percentage'];
                    $goalToUpdate->comments = $goal['comments'];
                    $goalToUpdate->updated_by = auth()->user()->id;
                    $goalToUpdate->save();
                }
            }
        }

        return response()->json('Objetivos actualizados correctamente.', 201);
    }

    public function approve($id)
    {
        $eda = Eda::find($id);

        if (!$eda) return response()->json('Eda not found', 404);

        $eda->approved = now();
        $eda->approved_by = auth()->user()->id;
        $eda->save();

        return response()->json('Objetivos aprobados correctamente. Se habilitó las evaluaciones y cuestionarios.', 200);
    }

    public function byEvaluation($id)
    {
        $goalsEvaluations = GoalEvaluation::where('id_evaluation', $id)->get();

        $items = $goalsEvaluations->map(function ($item) {
            $item->goal = $item->goal()->select('id', 'goal', 'description', 'indicators', 'percentage')->first();
            $item->evaluation = $item->evaluation;
            return $item;
        });

        return response()->json($items, 200);
    }
}
