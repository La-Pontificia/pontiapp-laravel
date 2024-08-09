<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;

class QuestionnaireTemplateController extends Controller
{
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

        foreach ($questions as $index => $question) {
            Question::create([
                'order' => $index + 1,
                'question' => $question['question'],
                'template_id' => $template->id,
                'created_by' => auth()->user()->id,
            ]);
        }

        return response()->json('Plantilla creada correctamente.', 200);
    }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'for' => 'required|in:collaborators,supervisors',
    //         'questions_to_create' => ['array'],
    //         'questions_to_update' => ['array'],
    //         'questions_to_delete' => ['array'],
    //     ]);

    //     $rulePerQuestion = [
    //         'order' => ['required', 'integer', 'min:1'],
    //         'question' => ['required', 'string', 'max:500'],
    //     ];

    //     $questions_to_create = $request->questions_to_create;
    //     $questions_to_update = $request->questions_to_update;
    //     $questions_to_delete = $request->questions_to_delete;

    //     // validate each quesions
    //     if ($questions_to_create) {
    //         foreach ($questions_to_create as $question) {
    //             $validator = validator($question, $rulePerQuestion);
    //             if ($validator->fails()) {
    //                 return response()->json(['error' => $validator->errors()], 400);
    //             }
    //         }
    //     }

    //     if ($questions_to_update) {
    //         foreach ($questions_to_update as $question) {
    //             $validator = validator($question, $rulePerQuestion);
    //             if ($validator->fails()) {
    //                 return response()->json(['error' => $validator->errors()], 400);
    //             }
    //         }
    //     }

    //     // delete each question
    //     if ($questions_to_delete) {
    //         foreach ($questions_to_delete as $questionId) {
    //             $question = Question::find($questionId);
    //             if ($question) {
    //                 $question->delete();
    //             }
    //         }
    //     }

    //     $template = Template::find($request->id);

    //     // create each question
    //     if ($questions_to_create) {
    //         foreach ($questions_to_create as $question) {
    //             Question::create([
    //                 'order' => $question['order'],
    //                 'question' => $question['question'],
    //                 'id_template' => $template->id,
    //                 'created_by' => auth()->user()->id,
    //             ]);
    //         }
    //     }

    //     // update each questions
    //     if ($questions_to_update) {
    //         foreach ($questions_to_update as $question) {
    //             $questionToUpdate = Question::find($question['id']);
    //             $hasBeenEdited = $questionToUpdate->question !== $question['question'] ||
    //                 $questionToUpdate->order !== $question['order'];
    //             if ($questionToUpdate && $hasBeenEdited) {
    //                 $questionToUpdate->question = $question['question'];
    //                 $questionToUpdate->order = $question['order'];
    //                 $questionToUpdate->updated_by = auth()->user()->id;
    //                 $questionToUpdate->save();
    //             }
    //         }
    //     }

    //     $template->title = $request->title;
    //     $template->for = $request->for;
    //     $template->updated_by = auth()->user()->id;
    //     $template->save();

    //     return response()->json($template, 200);
    // }

    // public function changeInUse($id)
    // {
    //     $template = Template::find($id);

    //     $for = $template->for;

    //     $match = Template::where('for', $for)->get();

    //     if ($match) {
    //         foreach ($match as $t) {
    //             $t->in_use = false;
    //             $t->save();
    //         }
    //     }


    //     $template->in_use = true;
    //     $template->save();

    //     return response()->json($template, 200);
    // }
}
