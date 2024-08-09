<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $user = User::where('email', $azureUser->getEmail())->first();

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
        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     return redirect()->intended('/');
        // }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales inválidas'])->onlyInput('email');
        }

        if (!$user->status) {
            return back()->withErrors(['email' => 'Tu cuenta no está activa. Comunícate con el administrador.'])->onlyInput('email');
        }

        return redirect('/login')->with('error', 'Credenciales incorrectas, Intente de nuevo.');
    }
}
