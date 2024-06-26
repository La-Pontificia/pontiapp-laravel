<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AccessComposerServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }


    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = auth()->user();
            if ($user) {
                $view->with('current_user', $user);
            }
        });
    }
}
