<?php

namespace App\Providers;

use App\Models\Acceso;
use App\Models\Colaboradore;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AccessComposerServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            if ($this->getColab()) {
                $view->with('colaborador_actual', $this->getColab());
            }
        });
    }

    function getColab()
    {
        $user = auth()->user();
        if ($user) return $user->colaborador;
    }
}
