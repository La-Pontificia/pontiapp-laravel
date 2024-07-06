<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    use AuthenticatesUsers;
    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToAzure()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleAzureCallback()
    {
        $azureUser = Socialite::driver('azure')->user();
        $email = Email::where('email', $azureUser->email)->first();

        if (!$email) {
            return redirect('/login')->with('error', 'La cuenta no está asociada a un usuario. Comunícate con un administrador.');
        }

        $user = $email->user;

        if (!$user) {
            return redirect('/login')->with('error', 'No se encontró un usuario asociado a este email. Comunícate con un administrador.');
        }

        if (!$user->status) {
            return redirect('/login')->with('error', 'Tu cuenta no se encuentra habilitada. Comunícate con un administrador.');
        }

        Auth::login($user);
        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status) return redirect()->intended($this->redirectPath());
        Auth::logout();
        return redirect('/login')->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect('/login')->with('error', 'Credenciales incorrectas, Intente de nuevo.');
    }
}
