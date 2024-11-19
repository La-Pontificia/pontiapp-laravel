<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireTemplateController extends Controller
{

    public function createQuestions($questions, $template)
    {
        foreach ($questions as $index => $question) {
            Question::create([
                'order' => $index + 1,
                'question' => $question['question'],
                'template_id' => $template->id,
                'created_by' => Auth::id(),
            ]);
        }
    }

    public function create(Request $req)
    {
        $req->validate([
            'title' => 'required',
            'questions' => 'required|array',
        ]);

        $rulePerQuestion = [
            'question' => ['required', 'string', 'max:500'],
        ];

        $questions = $req->questions;

        // validate each quesions
        foreach ($questions as $question) {
            $validator = validator($question, $rulePerQuestion);
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }
        }

        $template = QuestionnaireTemplate::create([
            'title' => $req->title,
            'created_by' => Auth::id(),
        ]);

        $this->createQuestions($questions, $template);

        return response()->json('Plantilla creada correctamente.', 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'title' => 'required',
            'questions' => 'required|array',
            'deleteIds' => 'array',
        ]);

        $rulePerQuestion = [
            'question' => ['required', 'string', 'max:500'],
        ];

        $template = QuestionnaireTemplate::find($id);
        if (!$template) return response()->json('Plantilla no encontrada.', 404);

        if ($req->questions) {
            foreach ($req->questions as $question) {
                $validator = validator($question, $rulePerQuestion);
                if ($validator->fails()) return response()->json($validator->errors()->first(), 400);
            }
        }

        foreach ($req->questions as $i => $question) {
            $order = $i + 1;
            if (isset($question['id'])) {
                $questionToUpdate = Question::find($question['id']);
                $questionToUpdate->order = $order;
                $questionToUpdate->question = $question['question'];
                $questionToUpdate->save();
            }

            if (!isset($question['id'])) {
                $question = Question::create([
                    'order' => $order,
                    'question' => $question['question'],
                    'template_id' => $template->id,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        if ($req->deleteIds) {
            foreach ($req->deleteIds as $id) {
                $question = Question::find($id);
                $question->archived = true;
                $question->save();
            }
        }

        $template->title = $req->title;
        $template->updated_by = Auth::id();
        $template->save();

        return response()->json('Plantilla actualizado correctamente.', 200);
    }

    public function use($id, $for)
    {
        $template = QuestionnaireTemplate::find($id);

        if ($for !== 'collaborators' && $for !== 'supervisors') {
            return response()->json('El uso de la plantilla no es válido.', 400);
        }

        QuestionnaireTemplate::where('use_for', $for)->update(['use_for' => null]);

        $template->use_for = $for;
        $template->save();

        return response()->json('Plantilla en uso.', 200);
    }

    public function archive($id)
    {
        $template = QuestionnaireTemplate::find($id);

        $template->archived = true;
        $template->save();

        return response()->json('Plantilla archivada.', 200);
    }

    public function delete($id)
    {
        $template = QuestionnaireTemplate::find($id);
        $template->delete();
        return response()->json('Plantilla eliminada.', 200);
    }
}
