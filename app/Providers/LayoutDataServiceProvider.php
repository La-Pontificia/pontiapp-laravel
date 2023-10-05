<?php

namespace App\Providers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\Objetivo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class LayoutDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $edas = Eda::orderBy('created_at', 'desc')->get();
            $currentEda = Eda::where('wearing', 1)->first();
            $view->with('edas', $edas);
            $view->with('currentEda', $currentEda);
        });

        // View::composer('layouts.profile', function ($view) {
        //     $edas = Eda::orderBy('created_at', 'desc')->get();
        //     $currentEda = Eda::where('wearing', 1)->first();
        //     $view->with('edas', $edas);
        //     $view->with('currentEda', $currentEda);
        // });
    }
}
