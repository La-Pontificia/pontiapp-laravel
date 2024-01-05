<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Evaluacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

/**
 * Class EdaColabController
 * @package App\Http\Controllers
 */
class EdaColabController extends Controller
{

    public function cambiarEstado(Request $request)
    {

        $id = $request->id;
        $estado = $request->estado;

        if (!$id || !$estado) {
            return response()->json(['error' => 'El id y el estado es requerido'], 404);
        }
        if ($estado != 1 && $estado != 2 && $estado != 3 && $estado != 4) {
            return response()->json(['error' => 'El estado debe ser 1, 2, 3 o 4'], 404);
        }

        try {
            $edaColab = EdaColab::find($id);
            $edaColab->estado = $estado;
            if ($estado == 1) {
                $edaColab->f_envio = \Carbon\Carbon::now();
            } elseif ($estado == 2) {
                $edaColab->f_aprobacion = \Carbon\Carbon::now();
            } elseif ($estado == 3) {
                $edaColab->f_autocalificacion = \Carbon\Carbon::now();
            }
            $edaColab->save();
            return response()->json(['msg' => 'Estado cambiado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    public function cerrar($id)
    {
        try {

            $eda = EdaColab::find($id);
            $evaluacion2 = $eda->evaluacion2;
            $promedio = $evaluacion2->promedio;
            $eda->cerrado = true;
            $eda->promedio = $promedio;
            $eda->fecha_cerrado = \Carbon\Carbon::now();
            $eda->save();
            return response()->json(['msg' => 'Eda cerrado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    public function enviar($id)
    {
        try {

            $eda = EdaColab::find($id);
            $eda->enviado = true;
            $eda->fecha_envio = \Carbon\Carbon::now();
            $eda->save();
            return response()->json(['msg' => 'Eda enviado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    public function aprobar($id)
    {
        try {

            $eda = EdaColab::find($id);
            $eda->aprobado = true;
            $eda->fecha_aprobado = \Carbon\Carbon::now();
            $eda->save();
            return response()->json(['msg' => 'Eda Aprobado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    public function crear(Request $request)
    {
        $colaboradorExiste = Colaboradore::find($request->id_colab);
        if (!$colaboradorExiste) return response()->json(['error' => 'El colaborador no existe'], 404);
        $edaExiste = Eda::find($request->id_eda);
        if (!$edaExiste) return response()->json(['error' => 'La eda no existe'], 404);
        $eva1 = Evaluacione::create();
        $eva2 = Evaluacione::create();

        // nuevo edaColab
        EdaColab::create([
            'id_eda' => $edaExiste->id,
            'id_colaborador' => $colaboradorExiste->id,
            'id_evaluacion' => $eva1->id,
            'id_evaluacion_2' => $eva2->id,
        ]);
        return response()->json(['msg' => 'Eda creada'], 200);
    }
}
