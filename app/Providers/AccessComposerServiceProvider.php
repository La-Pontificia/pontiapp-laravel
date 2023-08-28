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
        View::composer('layouts.app', function ($view) {
            $user = auth()->user();

            if ($user) {
                $id = $user->id;
                $colab = Colaboradore::where([
                    'id_usuario' => $id,
                ])->first();

                $accesos = Acceso::where('id_colaborador', $colab->id)
                    ->where('acceso', 1)
                    ->get();
                $view->with('accesos', $accesos);
            }
        });

        View::composer('layouts.maintenance', function ($view) {
            $user = auth()->user();

            if ($user) {
                $id = $user->id;
                $colab = Colaboradore::where([
                    'id_usuario' => $id,
                ])->first();

                $accesos = Acceso::where('id_colaborador', $colab->id)
                    ->where('acceso', 1)
                    ->get();
                $view->with('accesos', $accesos);
            }
        });
    }
}
