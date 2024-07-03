<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
{

    public function by_template($id)
    {
        $questions = Question::where('id_template', $id)->get();
        return response()->json($questions);
    }
}
