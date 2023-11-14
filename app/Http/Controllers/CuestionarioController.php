<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use Illuminate\Http\Request;

/**
 * Class CuestionarioController
 * @package App\Http\Controllers
 */
class CuestionarioController extends Controller
{
    public function index()
    {
        return view('cuestionario.index');
    }
    public function preguntas()
    {
        return view('cuestionario.preguntas');
    }
}
