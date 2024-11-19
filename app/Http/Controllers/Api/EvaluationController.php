<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\GoalEvaluation;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function selfqualify(Request $req, $id)
    {

        $req->validate([
            'items' => 'required|array',
        ]);

        $items = $req->items;
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
        $evaluation->self_rated_by = Auth::id();
        $evaluation->save();

        $this->auditService->registerAudit('Objetivos autocalificados', 'Se han autocalificado los objetivos', 'edas', 'selfqualify', $req);

        return response()->json('Objetivos autocalificados correctamente.', 200);
    }

    public function qualify(Request $req, $id)
    {
        $req->validate([
            'items' => 'required|array',
        ]);

        $items = $req->items;
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
        $evaluation->qualified_by = Auth::id();
        $evaluation->save();

        $this->auditService->registerAudit('Objetivos calificados', 'Se han calificado los objetivos', 'edas', 'qualify', $req);

        return response()->json('Objetivos calificados correctamente.', 200);
    }

    public function close($id)
    {

        $evaluation = Evaluation::find($id);

        if (!$evaluation)
            return response()->json('Eda not found', 404);

        $evaluation->closed = now();
        $evaluation->closed_by = Auth::id();
        $evaluation->save();

        $this->auditService->registerAudit('Evaluación cerrada', 'Se ha cerrado una evaluación', 'edas', 'close', request());

        return response()->json('Evaluación cerrada correctamente', 200);
    }

    public function feedback(Request $req, $id)
    {
        $req->validate([
            'feedback' => 'string|nullable',
            'feedback_score' => 'required|numeric|max:5|min:1',
        ]);

        $evaluation = Evaluation::find($id);

        if (!$evaluation)
            return response()->json('Evaluation not found', 404);

        $evaluation->feedback = $req->feedback;
        $evaluation->feedback_by = Auth::id();
        $evaluation->feedback_score = $req->feedback_score;
        $evaluation->feedback_at = now();
        $evaluation->save();

        $this->auditService->registerAudit('Feedback enviado', 'Se ha enviado un feedback', 'edas', 'feedback', $req);

        return response()->json('Feedback enviado correctamente', 200);
    }

    public function readFeedback($id)
    {
        $evaluation = Evaluation::find($id);

        if (!$evaluation)
            return response()->json('Evaluation not found', 404);

        $evaluation->feedback_read_at = now();
        $evaluation->save();

        return response()->json('Feedback leído correctamente', 200);
    }
}
