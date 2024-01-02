<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\CuestionarioPregunta;
use App\Models\Eda;
use App\Models\EdaColab;
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

    public function cuestionarioEda(Request $request)
    {
        try {
            $id_eda_colab = $request->id_eda;
            $isColab = $request->isColab;
            $respuestas = $request->respuestas;

            $current = $this->getCurrentColab();
            $cuestionario = Cuestionario::create([
                'id_colaborador' => $current->id,
            ]);

            foreach ($respuestas as $respuesta) {
                CuestionarioPregunta::create([
                    'id_cuestionario' => $cuestionario->id,
                    'id_pregunta' => $respuesta['id_pregunta'],
                    'respuesta' => $respuesta['respuesta'],
                ]);
            }

            $edaColab = EdaColab::find($id_eda_colab);
            if (!$edaColab) return response()->json(['success' => false, 'error' => 'Eda no encontrada'], 400);

            if ($isColab) {
                $edaColab->update([
                    'id_cuestionario_colab' => $cuestionario->id,
                ]);
            } else {
                $edaColab->update([
                    'id_cuestionario_super' => $cuestionario->id,
                ]);
            }
            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }
}
