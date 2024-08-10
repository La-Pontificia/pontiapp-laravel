<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;

class QuestionnaireTemplateController extends Controller
{

    public function createQuestions($questions, $template)
    {
        foreach ($questions as $index => $question) {
            Question::create([
                'order' => $index + 1,
                'question' => $question['question'],
                'template_id' => $template->id,
                'created_by' => auth()->user()->id,
            ]);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'for' => 'required|in:collaborators,supervisors',
            'questions' => 'required|array',
        ]);

        $rulePerQuestion = [
            'question' => ['required', 'string', 'max:500'],
        ];

        $questions = $request->questions;

        // validate each quesions
        foreach ($questions as $question) {
            $validator = validator($question, $rulePerQuestion);
            if ($validator->fails()) {
                return response()->json($validator->errors()->first(), 400);
            }
        }

        $template = QuestionnaireTemplate::create([
            'title' => $request->title,
            'for' => $request->for,
            'created_by' => auth()->user()->id,
        ]);

        $this->createQuestions($questions, $template);

        return response()->json('Plantilla creada correctamente.', 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'for' => 'required|in:collaborators,supervisors',
            'questions' => 'required|array',
            'deleteIds' => 'array',
        ]);

        $rulePerQuestion = [
            'question' => ['required', 'string', 'max:500'],
        ];

        $template = QuestionnaireTemplate::find($id);
        if (!$template) return response()->json('Plantilla no encontrada.', 404);

        if ($request->questions) {
            foreach ($request->questions as $question) {
                $validator = validator($question, $rulePerQuestion);
                if ($validator->fails()) return response()->json($validator->errors()->first(), 400);
            }
        }

        foreach ($request->questions as $i => $question) {
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
                    'created_by' => auth()->user()->id,
                ]);
            }
        }

        if ($request->deleteIds) {
            foreach ($request->deleteIds as $id) {
                $question = Question::find($id);
                $question->archived = true;
                $question->save();
            }
        }

        $template->title = $request->title;
        $template->for = $request->for;
        $template->updated_by = auth()->user()->id;
        $template->save();

        return response()->json('Plantilla actualizado correctamente.', 200);
    }

    public function use($id)
    {
        $template = QuestionnaireTemplate::find($id);

        $for = $template->for;

        $match = QuestionnaireTemplate::where('for', $for)->get();

        if ($match) {
            foreach ($match as $t) {
                $t->in_use = false;
                $t->save();
            }
        }

        $template->in_use = true;
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
