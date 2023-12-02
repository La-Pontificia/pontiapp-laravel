<?php

namespace App\Providers;

use App\Models\Colaboradore;
use App\Models\Objetivo;
use App\Models\Supervisore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
    }
}
