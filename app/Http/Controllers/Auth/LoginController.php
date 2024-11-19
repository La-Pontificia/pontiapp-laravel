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
            return redirect('/login')->with('error', 'Tu cuenta institucional "' . $azureUser->getEmail() . '", no esta disponible en esta aplicación.' .  ' Comunícate con un administrador.');
        }

        if (!$user->status) {
            return redirect('/login')->with('error', 'Tu cuenta no se encuentra habilitada. Comunícate con un administrador.');
        }

        Auth::login($user);

        return redirect('/');
    }

    protected function authenticated(Request $req, $user)
    {
        if ($user->status) return redirect()->intended($this->redirectPath());
        Auth::logout();
        return redirect('/login')->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
    }

    public function login(Request $req)
    {
        //  $credentials = $req->only('email', 'password')
        //  if (Auth::attempt($credentials)) {
        //      return redirect()->intended('/');
        //  }

        $credentials = $req->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Credeniales incorrectas, Intente de nuevo.');
        }

        if (!$user->status) {
            return back()->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect('/login')->with('error', 'Credeniales incorrectas, Intente de nuevo.');
    }
}
