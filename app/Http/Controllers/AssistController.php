<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

class AssistController extends Controller
{
    public function index()
    {
        $assists = Attendance::orderBy('punch_time', 'desc')->paginate();
        return view('pages.assists.index', compact('assists'))
            ->with('i', (request()->input('page', 1) - 1) * $assists->perPage());
    }
}
