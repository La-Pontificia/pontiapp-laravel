<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Objetivo;
use App\Models\Supervisore;
use Illuminate\Http\Request;

class ColabObjetivosController extends Controller
{
    public function index($id)
    {
        $colaborador = Colaboradore::find($id);

        // COLABORADOR USUARIO
        $user = auth()->user();
        if (!$user) {
            abort(404);
        }
        $colabUsuario = Colaboradore::where([
            'id_usuario' => $user->id,
        ])->first();


        $supervisores = Supervisore::where([
            'id_colaborador' => $id,
            'id_supervisor' => $colabUsuario->id
        ])->get();

        if (count($supervisores) == 0) {
            return view('colab-objetivo.denied', compact('id', 'colaborador'));
        }

        $objetivos = Objetivo::where([
            'id_colaborador' => $id
        ])->get();

        // SUMMARY
        $objetivoNewForm = new Objetivo();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota_super');

        return view('colab-objetivo.index', compact('id', 'colaborador', 'objetivos', 'totalPorcentaje', 'totalNota'));
    }
}
