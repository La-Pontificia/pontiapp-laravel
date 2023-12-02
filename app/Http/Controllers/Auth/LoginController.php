<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Colaboradore;
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
        $user = Socialite::driver('azure')->user();
        $colaborador = Colaboradore::where('correo_institucional', $user->email)->first();

        if (!$colaborador) return redirect('/login')->with('error', 'La cuenta seleccionada no existe en nuestra base de datos, Intente con otra cuenta.');
        if (!$colaborador->estado) return redirect('/login')->with('error', 'Tu cuenta no se encuentra habilitado, Comunicate con un administrador.');

        $user = User::where('id_colaborador', $colaborador->id)->first();
        Auth::login($user);
        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->colaborador->estado) return redirect()->intended($this->redirectPath());

        Auth::logout();
        return redirect('/login')->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
    }
}
