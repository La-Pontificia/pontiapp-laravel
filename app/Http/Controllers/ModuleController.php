<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        // get a last 5 users
        $users = User::orderBy('created_at', 'asc')->take(7)->get();
        return view('modules.+page', compact('users'));
    }
}
