<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Symfony\Component\HttpFoundation\Cookie;

class CheckBirthdays
{
    public function handle($request, Closure $next)
    {

        $dateKey = 'dateBirthdayModal';
        $showedKey = 'showedBirthdayModal';

        $showedBirthdayModal = $request->cookie($showedKey);
        $currentDateCookie = $request->cookie($dateKey);

        $now = Carbon::now()->format('Y-m-d');

        $todayFormatted = Carbon::today()->format('m-d');
        $showedToday = $showedBirthdayModal == 'true' && $currentDateCookie == $now;
        $birthdays = User::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [$todayFormatted])->get();
        $request->attributes->set('birthdayUsers', $birthdays);

        if ($showedToday) {
            $request->attributes->set('showBirthdayModal', false);
            return $next($request);
        }

        if (!$showedToday && $birthdays->isNotEmpty()) {
            $request->attributes->set('showBirthdayModal', true);
            $response = $next($request);
            $response->headers->setCookie(new Cookie($showedKey, 'false', time() + 86400, '/', null, false, false));
            $response->headers->setCookie(new Cookie($dateKey, $now, time() + 86400, '/', null, false, false));

            return $response;
        }

        return $next($request);
    }
}
