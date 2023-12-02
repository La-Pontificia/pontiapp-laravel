<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Feedback;
use App\Models\Objetivo;

use App\Models\Supervisore;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends GlobalController
{
    public function index()
    {
        $colaborador = $this->getCurrentColab();
        return view('profile.index', compact('colaborador'));
    }

    public function changePassword(Request $request)
    {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        if (!$this->matchPassword($currentPassword)) {
            return response()->json(['error' => 'La contraseña actual ingresada no es correcta.'], 404);
        }

        $userAuth = auth()->user();
        $user = User::find($userAuth->id);
        $user->password = bcrypt($newPassword);
        $user->save();

        return response()->json(['msg' => 'Contraseña actualizada correctamente'], 200);
    }

    public function matchPassword($password)
    {
        $hashedPassword = auth()->user()->password;
        return password_verify($password, $hashedPassword);
    }
}
