<?php

namespace App\Http\Controllers;


class SurveyController extends Controller
{
    public function index()
    {
        return view('pages.edas.surveys.index');
    }
}
