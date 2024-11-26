<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{

    public function index()
    {
        return view('docs.+page');
    }

    public function sendFeedback()
    {
        return view('docs.feedbacks.send.+page');
    }

    public function feedbackSuccess()
    {
        return view('docs.feedbacks.success.+page');
    }
}
