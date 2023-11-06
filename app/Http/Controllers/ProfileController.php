<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Feedback;
use App\Models\Objetivo;

use App\Models\Supervisore;
use Illuminate\Http\Request;

class ProfileController extends GlobalController
{
    private function commonOperations($id_colab, $id_eda_colab)
    {
        $currentColab = $this->getCurrentColab();
        $colaborador = Colaboradore::find($id_colab);
        $isMyprofile = false;
        $youSupervise = false;
        $hasSupervisor = false;
        $supervisor = null;
        $feedback = null;

        if ($colaborador->id_supervisor) {
            $supervisor = Colaboradore::find($colaborador->id_supervisor);
            if ($supervisor->id == $currentColab->id) $youSupervise = true;
            $hasSupervisor = true;
        }

        if ($colaborador->id == $currentColab->id) $isMyprofile = true;

        // COMMONS
        $edaColab = EdaColab::find($id_eda_colab);
        $wearingEda = EdaColab::where('id_colaborador', $colaborador->id)->where('cerrado', 0)->first();
        $objetivos = Objetivo::where('id_eda_colab', $id_eda_colab)->get();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota');
        $totalNotalAutoevaluacion = $objetivos->sum('autoevaluacion');
        $autocalificado = true;
        foreach ($objetivos as $objetivo) {
            if (!$objetivo->autoevaluacion > 0) {
                $autocalificado = false;
                break;
            }
        }
        $feedback = Feedback::where('id_eda_colab', $id_eda_colab)->first();
        // SUMMARY
        $objetivoNewForm = new Objetivo();
        $currentColabEda = $this->getEdaByColabId($colaborador->id);
        $edas = EdaColab::where('id_colaborador', $colaborador->id)->orderBy('created_at', 'desc')->get();
        return compact(
            'id_colab',
            'colaborador',
            'hasSupervisor',
            'isMyprofile',
            'objetivoNewForm',
            'youSupervise',
            'currentColabEda',
            'edas',
            'wearingEda',
            'edaColab',
            'supervisor',
            'objetivos',
            'totalPorcentaje',
            'totalNota',
            'totalNotalAutoevaluacion',
            'autocalificado',
            'feedback'

        );
    }

    public function getProfile($id)
    {
        $data = $this->commonOperations($id, $this->getEdaByColabId($id)->id);
        return view('profile.eda', $data);
    }




    public function getEdaByColabId($id)
    {
        $edaColab = EdaColab::where('id_colaborador', $id)->where('cerrado', 0)->first();
        return $edaColab;
    }

    public function getEdaByEdaId($id, $id_eda_colab)
    {
        $data = $this->commonOperations($id, $id_eda_colab);
        return view('profile.eda', $data);
    }

    public function myProfile()
    {
        $colab = $this->getCurrentColab();
        $data = $this->commonOperations($colab->id, $this->getEdaByColabId($colab->id)->id);
        return view('profile.index', $data);
    }

    public function myFirstEda()
    {
        $edaColab = $this->getEdaByColabId($this->getCurrentColab()->id);
        return redirect("/me/eda/$edaColab->id");
    }


    public function getEda($id)
    {
        $data = $this->commonOperations($id, $this->getEdaByColabId($id)->id);
        return view('profile.eda', $data);
    }


    public function myEda($id_eda)
    {
        $colab = $this->getCurrentColab();
        $data = $this->commonOperations($colab->id, $id_eda);
        return view('profile.eda', $data);
    }
}
