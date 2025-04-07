<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class AzureController extends Controller
{
    public function login(Request $req)
    {
        session(['redirectURL' => $req->query('redirectURL')]);
        session(['redirectErrorURL' => $req->query('redirectErrorURL')]);
        return Socialite::driver('azure')->redirect();
    }

    public function callback(Request $req)
    {
        $redirectURL = session('redirectURL');
        $redirectErrorURL = session('redirectErrorURL');

        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (\Exception $e) {
            error_log($e);
            return redirect($redirectErrorURL . '?error=auth_failed');
        }

        $user = User::where('email', $azureUser->getEmail())->first();


        if (!$user)  return redirect($redirectErrorURL . '?error=unauthorized');
        if (!$user->status) return redirect($redirectErrorURL . '?error=inactive');
        Auth::login($user);

        $agent = new Agent();
        $ip = $req->ip();
        $location = Location::get($ip);
        $userAgent = $req->header('User-Agent');
        $isMobile = $agent->isMobile();
        $isTablet = $agent->isTablet();
        $isDesktop = $agent->isDesktop();
        $browser = $agent->browser();
        $platform = $agent->platform();

        Session::create([
            'userId' => $user->id,
            'ip' => $ip,
            'userAgent' => $userAgent,
            'location' => $location ? $location->countryName . ', ' . $location->cityName : 'Unknown',
            'isMobile' => $isMobile,
            'isTablet' => $isTablet,
            'isDesktop' => $isDesktop,
            'browser' => $browser,
            'platform' => $platform,
        ]);

        $req->session()->regenerate();
        return redirect($redirectURL);
    }
}
