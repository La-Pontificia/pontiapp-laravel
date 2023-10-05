<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Objetivo;

use App\Models\Supervisore;
use Illuminate\Http\Request;

class ProfileController extends GlobalController
{
    private function commonOperations($id)
    {
        $currentColab = $this->getCurrentColab();
        $colaborador = Colaboradore::find($id);
        $isMyprofile = false;
        $youSupervise = false;
        $hasSupervisor = false;

        $supervisores = $this->getSupervisoresByColabID($colaborador->id);
        if (count($supervisores) > 0) $hasSupervisor = true;
        foreach ($supervisores as $super) {
            if ($super->id_supervisor == $currentColab->id) {
                $youSupervise = true;
                break;
            }
        }
        if ($colaborador->id == $currentColab->id) $isMyprofile = true;
        $objetivos = $this->getObjetivosByCurrentColab();

        // SUMMARY
        $objetivoNewForm = new Objetivo();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota_super');
        $currentColabEda = $this->getEdaByColabId($colaborador->id);
        return compact('id', 'colaborador', 'objetivos', 'totalPorcentaje', 'hasSupervisor', 'totalNota', 'isMyprofile', 'objetivoNewForm', 'youSupervise', 'currentColabEda');
    }

    public function getProfile($id)
    {
        $data = $this->commonOperations($id);
        return view('profile.eda', $data);
    }

    public function getInformation($id)
    {
        $data = $this->commonOperations($id);
        return view('profile.information', $data);
    }

    public function getHistory($id)
    {
        $data = $this->commonOperations($id);
        return view('profile.history', $data);
    }

    public function getEda($id)
    {
        $data = $this->commonOperations($id);
        return view('profile.eda', $data);
    }

    public function getSetting($id)
    {
        $data = $this->commonOperations($id);
        return view('profile.setting', $data);
    }

    public function myProfile()
    {
        $colab = $this->getCurrentColab();
        $data = $this->commonOperations($colab->id);
        return view('profile.eda', $data);
    }
}
