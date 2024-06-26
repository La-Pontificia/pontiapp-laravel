<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

class AssistController extends Controller
{
    public function index()
    {
        $assists = Attendance::where('emp_code', "80614134")->get();
        return view('pages.assists.index', compact('assists'));
    }
}
