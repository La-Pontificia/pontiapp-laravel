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
use Illuminate\Http\Request;

class EdaController extends Controller
{
    public function createIndependent(Request $request)
    {

        $request->validate([
            'year_id' => 'required|uuid',
            'user_id' => 'required|uuid',
        ]);

        $year_id = $request->year_id;
        $user_id = $request->user_id;
        $cuser = User::find(auth()->user()->id);
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
            'created_by' => auth()->user()->id,
        ]);

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

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
            'created_by' => auth()->user()->id,
        ]);

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

        return response()->json('Eda creado correctamente.', 200);
    }

    public function close(Request $request)
    {
        $eda = Eda::find($request->id);

        if (!$eda) return response()->json('La eda no existe', 404);

        if ($eda->closed) return response()->json('La eda ya esta cerrada', 404);

        $eda->closed = now();

        $eda->closed_by = auth()->user()->id;

        $eda->save();

        return response()->json('Eda cerrado correctamente. Se habilitó la posibilidad de resolver los cuestionarios asignados.', 200);
    }

    public function restart(Request $request)
    {
        $eda = Eda::find($request->id);

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

        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

        return response()->json('El eda se ha reiniciado correctamente.', 200);
    }

    public function questionnaire(Request $request, $id)
    {
        $eda = Eda::find($id);
        if (!$eda) return response()->json('La eda no existe', 404);
        if (!$eda->closed) return response()->json('La eda no esta cerrada', 404);
        $request->validate([
            'answers' => 'required|array',
        ]);
        $rulePerAnswer = [
            'question_id' => ['required', 'uuid'],
            'answer' => ['required', 'string'],
        ];
        foreach ($request->answers as $answer) {
            $validator = validator($answer, $rulePerAnswer);
            if ($validator->fails()) return response()->json($validator->errors()->first(), 400);
        }
        $firstQuestion = Question::find($request->answers[0]['question_id']);
        $questionnaire_template = QuestionnaireTemplate::find($firstQuestion->template_id);

        if (!$questionnaire_template) return response()->json('La plantilla no existe', 404);
        $questionnaire =  Questionnaire::create([
            'eda_id' => $eda->id,
            'questionnaire_template_id' => $questionnaire_template->id,
            'answered_by' => auth()->user()->id,
        ]);

        foreach ($request->answers as $answer) {
            QuestionnaireAnswer::create([
                'answer' => $answer['answer'],
                'question_id' => $answer['question_id'],
                'questionnaire_id' => $questionnaire->id,
            ]);
        }
        return response()->json('Cuestionario enviado correctamente', 200);
    }
}
