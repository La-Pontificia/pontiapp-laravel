<?php

namespace App\Http\Controllers;

use App\Models\EdaColab;
use App\Models\EdaObj;
use App\Models\Objetivo;
use Illuminate\Http\Request;

/**
 * Class ObjetivoController
 * @package App\Http\Controllers
 */
class ObjetivoController extends GlobalController
{


    public function index()
    {
        $colab = $this->getCurrentColab();


        $objetivos = Objetivo::where('id_colaborador', $colab->id)->paginate();
        $objetivoNewForm = new Objetivo();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota_super');

        return view('objetivo.index', compact('objetivos', 'objetivoNewForm', 'totalPorcentaje', 'totalNota'))
            ->with('i', (request()->input('page', 1) - 1) * $objetivos->perPage());
    }

    public function create()
    {
        $objetivo = new Objetivo();
        return view('objetivo.create', compact('objetivo'));
    }


    public function store(Request $request)
    {
        // Validar el porcentaje
        if ($request->porcentaje < 1 || $request->porcentaje > 100) {
            return response()->json(['error' => 'El porcentaje debe estar entre 1 y 100'], 400);
        }

        // Validar la descripción e indicadores
        $maxTextLength = 2000;
        $requiredFields = ['descripcion' => 'La descripción', 'indicadores' => 'Los indicadores'];

        foreach ($requiredFields as $field => $fieldName) {
            if (!$request->$field || strlen($request->$field) > $maxTextLength) {
                return response()->json(['error' => "$fieldName no puede estar vacío o tener más de $maxTextLength caracteres"], 400);
            }
        }

        // Validar la suma total del porcentaje
        $validatedData = $request->validate(Objetivo::$rules);
        $edaColab = $this->getCurrentEdaByCurrentColab();

        $objetivos = Objetivo::where('id_eda_colab', $edaColab->id);
        $totalPorcentaje = $objetivos->sum('porcentaje') + $request->porcentaje;

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }

        // Crear el nuevo objetivo
        $data = array_merge($validatedData, [
            'id_eda_colab' => $edaColab->id,
            'porcentaje' =>  $request->input('porcentaje'),
            'porcentaje_inicial' => $request->input('porcentaje')
        ]);

        Objetivo::create($data);
        return response()->json(['success' => true], 202);
    }

    public function deleteObjetivo($id)
    {
        try {
            $objetivo = Objetivo::findOrFail($id);
            $objetivo->delete();
            return response()->json(['msg' => 'Objetivo eliminado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Objetivo no encontrado'], 404);
        }
    }


    public function show($id)
    {
        $objetivo = Objetivo::find($id);

        return view('objetivo.show', compact('objetivo'));
    }

    public function edit($id)
    {
        $objetivo = Objetivo::find($id);
        return view('objetivo.edit', compact('objetivo'));
    }


    public function getObjetivosByCurrentColab()
    {
        $edaColab = $this->getCurrentEdaByCurrentColab();
        $objetivos = Objetivo::where('id_eda_colab', $edaColab->id)->get();
        return $objetivos;
    }


    public function update(Request $request, Objetivo $objetivo)
    {
        // Validar el porcentaje
        if ($request->porcentaje < 1 || $request->porcentaje > 100) {
            return response()->json(['error' => 'El porcentaje debe estar entre 1 y 100'], 400);
        }


        // Validar la descripción e indicadores
        $maxTextLength = 2000;
        $requiredFields = ['descripcion' => 'La descripción', 'indicadores' => 'Los indicadores'];

        foreach ($requiredFields as $field => $fieldName) {
            if (!$request->$field || strlen($request->$field) > $maxTextLength) {
                return response()->json(['error' => "$fieldName no puede estar vacío o tener más de $maxTextLength caracteres"], 400);
            }
        }

        $objetivos = Objetivo::where('id_eda_colab', $objetivo->id_eda_colab);
        $totalPorcentaje = ($objetivos->sum('porcentaje') - $objetivo->porcentaje) + $request->porcentaje;

        $edaColab = EdaColab::find($objetivo->id_eda_colab);

        if ($edaColab->estado == 1) {
            $objetivo->editado = 1;
        }

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }

        $objetivo->update($request->all());
        return response()->json(['success' => true], 200);
    }


    public function guardarAutocalificacion(Request $request)
    {
        try {
            $n_eva = $request->n_eva;
            $autocalificacionArray = $request->autocalificacionArray;
            foreach ($autocalificacionArray as $autocalificacion) {
                if (empty($autocalificacion['id']) || empty($autocalificacion['autocalificacion'])) {
                    return response()->json(['message' => 'Datos de objetivo no válidos'], 400);
                }
                if ($autocalificacion['autocalificacion'] < 1 || $autocalificacion['autocalificacion'] > 5) {
                    return response()->json(['message' => 'La calificación debe estar entre 1 y 5'], 400);
                }
                $this->cambiarNota($autocalificacion['id'], $autocalificacion['autocalificacion'], 'autoevaluacion', $n_eva);
            }
            return response()->json(['message' => 'Autocalificación guardada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 404);
        }
    }


    public function guardarCalificacion(Request $request)
    {
        try {
            $n_eva = $request->n_eva;
            $califacionArray = $request->califacionArray;
            foreach ($califacionArray as $calificacion) {
                if (empty($calificacion['id']) || empty($calificacion['autocalificacion'])) {
                    return response()->json(['message' => 'Datos de objetivo no válidos'], 400);
                }
                if ($calificacion['autocalificacion'] < 1 || $calificacion['autocalificacion'] > 5) {
                    return response()->json(['message' => 'La calificación debe estar entre 1 y 5'], 400);
                }
                $this->cambiarNota($calificacion['id'], $calificacion['autocalificacion'], 'promedio', $n_eva);
            }
            return response()->json(['message' => 'Autocalificación guardada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 404);
        }
    }


    public function agregarObjetivos(Request $request, $id_eda)
    {
        try {
            $objetivos = $request->objetivos;
            foreach ($objetivos as $objetivo) {

                if (empty($objetivo['objetivo']) || empty($objetivo['descripcion']) || empty($objetivo['indicadores']) || $objetivo['porcentaje'] < 1) {
                    return response()->json(['message' => 'Datos de objetivo no válidos'], 400);
                }

                $nuevoObjetivo = new Objetivo([
                    'id_eda_colab' => $id_eda,
                    'objetivo' => $objetivo['objetivo'],
                    'descripcion' => $objetivo['descripcion'],
                    'indicadores' => $objetivo['indicadores'],
                    'porcentaje' => $objetivo['porcentaje'],
                    'porcentaje_inicial' => $objetivo['porcentaje']
                ]);

                $nuevoObjetivo->save();
                $this->cambiarEstado(1, $id_eda);
            }
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 404);
        }
    }

    public function cambiarEstado($estado, $id_eda)
    {
        try {
            $edaColab = EdaColab::find($id_eda);
            if ($estado == 1) {
                $edaColab->enviado = true;
                $edaColab->fecha_envio = \Carbon\Carbon::now();
            } elseif ($estado == 2) {
                $edaColab->aprobado = true;
                $edaColab->fecha_aprobado = \Carbon\Carbon::now();
            } else {
                $edaColab->cerrado = true;
                $edaColab->fecha_cerrado = \Carbon\Carbon::now();
            }
            $edaColab->save();
            return response()->json(['msg' => 'Estado cambiado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    public function cambiarNota($id, $nota, $nombre_nota, $n_eva)
    {

        $objetivo = Objetivo::find($id);
        if ($n_eva == 1) {
            if ($nombre_nota == 'promedio')  $objetivo->promedio = $nota;
            else $objetivo->autocalificacion = $nota;
        } else {
            if ($nombre_nota == 'promedio')  $objetivo->promedio_2 = $nota;
            else $objetivo->autocalificacion_2 = $nota;
        }
        $objetivo->save();
        return response()->json(['success' => true, "objetivo autocalificado/calificado"], 200);
    }
}
