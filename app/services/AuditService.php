<?php

namespace App\services;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class AuditService
{

    public static function registerAudit($title, $description, $module, $action, $req)
    {
        $agent = new Agent();
        $location = Location::get($req->ip());
        Audit::create([
            'user_id' => Auth::id(),
            'module' => $module,
            'title' => $title,
            'description' => $description,
            'path' => $req->path(),
            'os' => $agent->platform(),
            'ip' => $req->ip(),
            'platform' => $agent->browser(),
            'device' => $agent->device(),
            'browser' => $agent->browser(),
            'country' => $location ? $location->countryName : null,
            'region' => $location ? $location->regionName : null,
            'city' => $location ? $location->cityName : null,
            'action' => $action
        ]);
    }
}
