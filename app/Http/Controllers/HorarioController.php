<?php

namespace App\Http\Controllers;

// use App\Models\Horario;
// use Illuminate\Http\Request;

class HorarioController extends Controller
{

    public function index()
    {
        // $horarios = Horario::orderBy('nombre', 'asc')->paginate();
        // $horario = new Horario();
        // return view('horario.index', compact('horarios', 'horario'))
        //     ->with('i', (request()->input('page', 1) - 1) * $horarios->perPage());
        return view('horario.index');
    }
}
