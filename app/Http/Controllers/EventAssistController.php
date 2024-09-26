<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventAssistController extends Controller
{
    public function index()
    {
        return view('modules.events.assists.+page');
    }
}
