<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/';

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales inválidas'])->onlyInput('email');
        }

        if (!$user->status) {
            return back()->withErrors(['email' => 'Tu cuenta no está activa. Comunícate con el administrador.'])->onlyInput('email');
        }

        // verify the password
        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            //        // if (Auth::attempt($credentials)) {
            // //     return redirect()->intended('/');
            // // }
            //     return redirect('/')->with('success', 'Bienvenido');
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    protected function authenticated(Request $req, $user)
    {
        if ($user->status) return redirect()->intended($this->redirectPath());
        Auth::logout();
        return redirect('/login')->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
    }

    public function loginAzure()
    {
        session(['origin_url' => url()->previous()]);
        return Socialite::driver('azure')->redirect();
    }

    public function callbackAzure(Request $req)
    {
        $originUrl = $req->session()->get('origin_url');
        $azureUser = Socialite::driver('azure')->user();
        $user = User::where('email', $azureUser->getEmail())->first();
        return redirect('http://localhost:3000/login');
    }
}
