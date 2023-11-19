<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\CuestionarioPregunta;
use App\Models\Plantilla;
use App\Models\Pregunta;
use Illuminate\Http\Request;

/**
 * Class CuestionarioController
 * @package App\Http\Controllers
 */
class CuestionarioController extends GlobalController
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

    public function cuestionarioEda(Request $request, $id_eda)
    {
        try {
            $respuestas = $request->respuestas;
            $de = $request->de == '1' ? 'colaborador' : 'supervisor'; // 1 colaborador, 2 supervisor
            $colab = $this->getCurrentColab();

            $cuestionario = Cuestionario::create([
                'id_eda' => $id_eda,
                'id_colaborador' => $colab->id,
                'de' => $de
            ]);

            foreach ($respuestas as $respuesta) {
                CuestionarioPregunta::create([
                    'id_cuestionario' => $cuestionario->id,
                    'id_pregunta' => $respuesta['id_pregunta'],
                    'respuesta' => $respuesta['respuesta'],
                ]);
            }

            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }
}
