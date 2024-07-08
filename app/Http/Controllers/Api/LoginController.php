<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $find = Email::where('email', $credentials['email'])->first();

        if (!$find) {
            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
        }

        if ($find->discharged) {
            return redirect('/login')->with('error', 'La cuenta ha sido dada de baja. Prueba con otro correo o Comunícate con un administrador.');
        }

        $user = $find->user;

        if (!$user->status) {
            return back()->withErrors(['email' => 'Tu cuenta no está activa. Comunícate con el administrador.'])->onlyInput('email');
        }


        // verify the password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status) return redirect()->intended($this->redirectPath());
        Auth::logout();
        return redirect('/login')->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
    }
}
