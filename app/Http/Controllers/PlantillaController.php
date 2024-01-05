<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\PlantillaPregunta;
use App\Models\Pregunta;
use Illuminate\Http\Request;

/**
 * Class PlantillaController
 * @package App\Http\Controllers
 */
class PlantillaController extends Controller
{
    public function crear(Request $request)
    {
        try {
            $nombre = $request->nombre;
            $ids_preguntas = $request->ids;
            $para = $request->para;
            if (!$nombre || !$ids_preguntas || !$para) {
                return response()->json(['error' => 'Faltan campos'], 401);
            }

            if ($para != '1' && $para != '2') {
                return response()->json(['error' => 'Valor inválido para el campo "para"'], 401);
            }

            $plantilla = Plantilla::create([
                'nombre' => $nombre,
                'para' => $para == 1 ? 'supervisores' : 'colaboradores'
            ]);


            foreach ($ids_preguntas as $id_pregunta) {
                PlantillaPregunta::create([
                    'id_plantilla' => $plantilla->id,
                    'id_pregunta' => $id_pregunta,
                ]);
            }

            return response()->json(['success' => true, 'plantilla' => $plantilla], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }

    public function index()
    {
        try {
            $plantillas = Plantilla::with('plantillaPreguntas.pregunta')->get();

            $plantillasPorPara = $plantillas->groupBy('para');
            $supervisores = $plantillasPorPara->get('supervisores', collect());
            $colaboradores = $plantillasPorPara->get('colaboradores', collect());

            $preguntasNoAsociadas = [];
            $preguntas = Pregunta::all();

            foreach ($plantillas as $plantilla) {
                $preguntasNoAsociadas[$plantilla->id] = Pregunta::whereDoesntHave('plantillaPreguntas', function ($query) use ($plantilla) {
                    $query->where('id_plantilla', $plantilla->id);
                })->get();
            }

            return view('cuestionario.index', compact('supervisores', 'colaboradores', 'preguntasNoAsociadas', 'preguntas'));
        } catch (\Exception $e) {
            return view('cuestionario.index');
        }
    }

    public function eliminarPregunta($id)
    {
        try {
            $pregunta = PlantillaPregunta::findOrFail($id);
            $pregunta->delete();
            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }

    public function agregarPregunta(Request $request, $id)
    {
        try {
            $id_pregunta = $request->id_pregunta;
            $plantilla = Plantilla::findOrFail($id);
            PlantillaPregunta::create([
                "id_plantilla" => $plantilla->id,
                "id_pregunta" => $id_pregunta
            ]);
            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }
    public function usar($id)
    {
        try {
            $plantilla = Plantilla::find($id);
            Plantilla::where('para', $plantilla->para)->update(['usando' => false]);
            $plantilla->usando = true;
            $plantilla->save();
            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }
}
