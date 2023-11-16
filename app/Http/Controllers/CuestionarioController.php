<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Plantilla;
use App\Models\Pregunta;
use Illuminate\Http\Request;

/**
 * Class CuestionarioController
 * @package App\Http\Controllers
 */
class CuestionarioController extends Controller
{
    public function index()
    {
        $preguntas = Pregunta::get();
        $plantillas = Plantilla::get();
        return view('cuestionario.index', compact('preguntas', 'plantillas'));
    }
    public function preguntas()
    {
        $preguntas = Pregunta::get();
        return view('cuestionario.preguntas.index', compact('preguntas'));
    }
}
