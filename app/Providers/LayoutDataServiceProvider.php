<?php

namespace App\Providers;

use App\Models\Colaboradore;
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
            $user = auth()->user();

            if ($user) {
                $id = $user->id;
                $colab = Colaboradore::where([
                    'id_usuario' => $id,
                ])->first();

                $objetivosDesaprobados = Objetivo::where('estado', 0)
                    ->where('id_colaborador', $colab->id)
                    ->where('notify_colab', 1)
                    ->whereNotNull('feedback')
                    ->get();

                $view->with('objetivosDesaprobados', $objetivosDesaprobados);
            }
        });
    }
}
