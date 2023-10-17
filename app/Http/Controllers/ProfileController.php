<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\EdaColab;
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
        $supervisor = null;

        if ($colaborador->id_supervisor) {
            $supervisor = Colaboradore::find($colaborador->id_supervisor);
            if ($supervisor->id == $currentColab->id) $youSupervise = true;
            $hasSupervisor = true;
        }

        if ($colaborador->id == $currentColab->id) $isMyprofile = true;
        // SUMMARY
        $objetivoNewForm = new Objetivo();

        $currentColabEda = $this->getEdaByColabId($colaborador->id);
        $edas = EdaColab::where('id_colaborador', $this->getCurrentColab()->id)->orderBy('created_at', 'desc')->get();
        return compact('id', 'colaborador', 'hasSupervisor', 'isMyprofile', 'objetivoNewForm', 'youSupervise', 'currentColabEda', 'edas');
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
        return view('profile.index', $data);
    }

    public function myHistory()
    {
        $colab = $this->getCurrentColab();
        $data = $this->commonOperations($colab->id);
        return view('profile.history', $data);
    }

    public function mySetting()
    {
        $colab = $this->getCurrentColab();
        $data = $this->commonOperations($colab->id);
        return view('profile.setting', $data);
    }
    public function myFirstEda()
    {
        $edaColab = EdaColab::where('id_colaborador', $this->getCurrentColab()->id)->where('wearing', 1)->first();
        return redirect("/me/eda/$edaColab->id");
    }

    public function myEda($id_eda)
    {
        $colab = $this->getCurrentColab();
        $edaColab = EdaColab::find($id_eda);
        $wearingEda = EdaColab::where('id_colaborador', $colab->id)->where('wearing', 1)->first();
        $data = $this->commonOperations($colab->id);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota_super');
        $data['edaColab'] = $edaColab;
        $data['objetivos'] = $objetivos;
        $data['totalPorcentaje'] = $totalPorcentaje;
        $data['totalNota'] = $totalNota;
        $data['wearingEda'] = $wearingEda;
        return view('profile.eda', $data);
    }
}
