<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;

class AssistController extends Controller
{
    public function index()
    {
        $assists = Attendance::orderBy('punch_time', 'desc')->paginate();
        return view('pages.assists.index', compact('assists'))
            ->with('i', (request()->input('page', 1) - 1) * $assists->perPage());
    }

    public function user($id_user)
    {
        $user = User::find($id_user);

        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $assists = Attendance::where('emp_code', $user->dni)->orderBy('punch_time', 'desc')->paginate();

        return view('pages.assists.user.schedules', compact('user', 'assists'))
            ->with('i', (request()->input('page', 1) - 1) * $assists->perPage());
    }
}
