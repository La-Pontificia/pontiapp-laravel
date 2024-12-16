<?php

namespace App\Http\Controllers\Api\AssistTerminal;

use App\Http\Controllers\Controller;
use App\Models\AssistTerminal;

class AssistTerminalController extends Controller
{
    public function all()
    {
        $terminals = AssistTerminal::all();
        return response()->json($terminals);
    }
}
