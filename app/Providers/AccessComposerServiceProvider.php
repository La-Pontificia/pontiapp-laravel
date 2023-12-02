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
                $view->with('a_puesto', $this->getPuestos());
                $view->with('colaborador_actual', $this->getColab());
                $view->with('a_colaborador', $this->getColaboradores());
                $view->with('a_area', $this->getAreas());
                $view->with('a_eda', $this->getEdas());
                $view->with('a_departamento', $this->getDepartamentos());
                $view->with('a_acceso', $this->getAccesos());
                $view->with('a_cargo', $this->getCargos());
                $view->with('a_sede', $this->getSedes());
                $view->with('a_objetivo', $this->getObjetivos());
                $view->with('a_reporte', $this->getReportes());
            }
        });
    }

    function getColab()
    {
        $user = auth()->user();
        if ($user) return $user->colaborador;
    }
    function getPuestos()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'puestos')
            ->first();
    }
    function getColaboradores()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'colaboradores')
            ->first();
    }
    function getAreas()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'areas')
            ->first();
    }
    function getEdas()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'edas')
            ->first();
    }
    function getDepartamentos()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'departamentos')
            ->first();
    }
    function getAccesos()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'accesos')
            ->first();
    }
    function getCargos()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'cargos')
            ->first();
    }
    function getSedes()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'sedes')
            ->first();
    }
    function getObjetivos()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'objetivos')
            ->first();
    }
    function getReportes()
    {
        $colab = $this->getColab();
        return Acceso::where('id_colaborador', $colab->id)
            ->where('modulo', 'reportes')
            ->first();
    }
}
