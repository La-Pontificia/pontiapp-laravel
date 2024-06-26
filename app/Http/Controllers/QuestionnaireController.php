<?php

namespace App\Http\Controllers;


class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('pages.questionnaires.index');
    }
}
