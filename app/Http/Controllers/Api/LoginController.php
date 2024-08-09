<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/';

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales inválidas'])->onlyInput('email');
        }

        if (!$user->status) {
            return back()->withErrors(['email' => 'Tu cuenta no está activa. Comunícate con el administrador.'])->onlyInput('email');
        }

        // verify the password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            //        // if (Auth::attempt($credentials)) {
            // //     return redirect()->intended('/');
            // // }
            //     return redirect('/')->with('success', 'Bienvenido');
            return redirect()->intended('/');
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
