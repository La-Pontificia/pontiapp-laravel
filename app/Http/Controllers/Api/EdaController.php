<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use App\Models\QuestionnaireTemplate;
use App\Models\User;
use App\Models\Year;
use App\services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EdaController extends Controller
{

    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function createIndependent(Request $req)
    {

        $req->validate([
            'year_id' => 'required|uuid',
            'user_id' => 'required|uuid',
        ]);

        $year_id = $req->year_id;
        $user_id = $req->user_id;
        $cuser = User::find(Auth::id());
        $user = User::find($user_id);
        $year = Year::find($year_id);

        if (!$year->status) return response()->json('El año seleccionado no esta activo', 404);
        if (!$user->status) return response()->json('El usuario seleccionado no esta activo', 404);

        $hasAccess = ($cuser->has('edas:create') && $user->supervisor_id === $cuser->id || $cuser->has('edas:create_all')) || $cuser->isDev();
        if (!$hasAccess) return response()->json('No tienes permisos para realizar esta acción', 403);


        $alreadyExists = Eda::where('id_user', $user_id)->where('id_year', $year_id)->first();

        if ($alreadyExists) return response()->json('El usuario ya tiene un eda con el año seleccionado.', 400);

        $evaluationArray = [1, 2];

        $eda = Eda::create([
            'id_user' => $user_id,
            'id_year' => $year_id,
            'created_by' => Auth::id(),
        ]);

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

        $this->auditService->registerAudit('Eda creado', 'Se ha creado un eda', 'edas', 'create', $req);

        return response()->json('Eda creado correctamente.', 200);
    }

    public function create($year_id, $user_id)
    {
        $evaluationArray = [1, 2];

        $foundedUser = User::find($user_id);
        if (!$foundedUser) return response()->json('El usuario no existe', 404);

        $foundYear = Year::find($year_id);
        if (!$foundYear) return response()->json('La eda selecionado no existe', 404);
        if (!$foundYear->status) return response()->json('El año seleccionado no esta activo', 404);

        $eda = Eda::create([
            'id_user' => $foundedUser->id,
            'id_year' => $foundYear->id,
            'created_by' => Auth::id(),
        ]);

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }
        $this->auditService->registerAudit('Eda creado', 'Se ha creado un eda', 'edas', 'create', request());


        return response()->json('Eda creado correctamente.', 200);
    }

    public function close(Request $req)
    {
        $eda = Eda::find($req->id);

        if (!$eda) return response()->json('La eda no existe', 404);

        if ($eda->closed) return response()->json('La eda ya esta cerrada', 404);

        $eda->closed = now();

        $eda->closed_by = Auth::id();

        $eda->save();

        $this->auditService->registerAudit('Eda cerrado', 'Se ha cerrado un eda', 'edas', 'update', $req);

        return response()->json('Eda cerrado correctamente. Se habilitó la posibilidad de resolver los cuestionarios asignados.', 200);
    }

    public function restart(Request $req)
    {
        $eda = Eda::find($req->id);

        if (!$eda) return response()->json('La eda no existe', 404);

        $eda->closed = null;
        $eda->sent = null;
        $eda->sent_by = null;
        $eda->approved = null;
        $eda->approved_by = null;
        $eda->closed_by = null;

        $eda->questionnaires()->delete();
        $eda->goals()->delete();
        $eda->evaluations()->delete();

        $evaluationArray = [1, 2];

        $eda->save();

        $this->auditService->registerAudit('Eda reiniciado', 'Se ha reiniciado un eda', 'edas', 'update', $req);

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

        return response()->json('El eda se ha reiniciado correctamente.', 200);
    }

    public function questionnaire(Request $req, $id)
    {
        $eda = Eda::find($id);
        if (!$eda) return response()->json('La eda no existe', 404);
        if (!$eda->closed) return response()->json('La eda no esta cerrada', 404);
        $req->validate([
            'answers' => 'required|array',
        ]);
        $rulePerAnswer = [
            'question_id' => ['required', 'uuid'],
            'answer' => ['required', 'string'],
        ];
        foreach ($req->answers as $answer) {
            $validator = validator($answer, $rulePerAnswer);
            if ($validator->fails()) return response()->json($validator->errors()->first(), 400);
        }
        $firstQuestion = Question::find($req->answers[0]['question_id']);
        $questionnaire_template = QuestionnaireTemplate::find($firstQuestion->template_id);

        if (!$questionnaire_template) return response()->json('La plantilla no existe', 404);
        $questionnaire =  Questionnaire::create([
            'eda_id' => $eda->id,
            'questionnaire_template_id' => $questionnaire_template->id,
            'answered_by' => Auth::id(),
        ]);

        foreach ($req->answers as $answer) {
            QuestionnaireAnswer::create([
                'answer' => $answer['answer'],
                'question_id' => $answer['question_id'],
                'questionnaire_id' => $questionnaire->id,
            ]);
        }
        return response()->json('Cuestionario enviado correctamente', 200);
    }
}
