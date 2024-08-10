<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireTemplate;

class QuestionController extends Controller
{

    public function questions($id)
    {
        $template = QuestionnaireTemplate::find($id);
        $questions = $template->questions;

        return response()->json($questions);
    }
}
