<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Goal;
use App\Models\GoalEvaluation;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }


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
                'created_by' => Auth::id(),
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

    public function sent(Request $req, $id)
    {
        $eda = Eda::find($id);

        if (!$eda) {
            return response()->json('Eda no encontrado', 404);
        }

        $req->validate([
            'goals' => ['required', 'array'],
        ]);

        $goals = $req->goals;

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
        $eda->sent_by = Auth::id();
        $eda->save();

        $this->auditService->registerAudit('Objetivos enviados', 'Se han enviado los objetivos', 'edas', 'sent', $req);

        // send emails

        if ($eda->user->supervisor) {
            Mail::raw('Hola, ' . $eda->user->supervisor->first_name . ' ' . $eda->user->first_name . ', acaba de enviar sus objetivos', function ($message) use ($eda) {
                $message->to($eda->user->supervisor->email)
                    ->subject('Correo de Prueba');
            });
        }


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

    public function update(Request $req, $id)
    {

        $req->validate([
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
        foreach ($req->goals as $goal) {
            $validator = validator($goal, $rulePerGoal);
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }
        }

        $goals_to_create = array_filter($req->goals, function ($goal) {
            return !isset($goal['id']) || $goal['id'] === null;
        });

        $goals_to_update = array_filter($req->goals, function ($goal) {
            return isset($goal['id']) && $goal['id'] !== null;
        });

        $goals_to_delete = $req->goals_to_delete;

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
                    $goalToUpdate->updated_by = Auth::id();
                    $goalToUpdate->save();
                }
            }
        }


        if ($eda->user->supervisor) {
            Mail::raw('Hola, ' . $eda->user->supervisor->first_name . ', ' . $eda->user->first_name . ' acaba de enviar sus objetivos', function ($message) use ($eda) {
                $message->to($eda->user->supervisor->email)
                    ->subject('Envio de objetivos');
            });
        }

        $this->auditService->registerAudit('Objetivos actualizados', 'Se han actualizado los objetivos', 'edas', 'update', $req);

        return response()->json('Objetivos actualizados correctamente.', 201);
    }

    public function approve($id)
    {
        $eda = Eda::find($id);

        if (!$eda) return response()->json('Eda not found', 404);

        $eda->approved = now();
        $eda->approved_by = Auth::id();
        $eda->save();

        $this->auditService->registerAudit('Objetivos aprobados', 'Se han aprobado los objetivos', 'edas', 'approve', request());

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
