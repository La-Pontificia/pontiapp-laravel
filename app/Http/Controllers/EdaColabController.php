<?php

namespace App\Http\Controllers;

use App\Models\EdaColab;
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
            } elseif ($estado == 4) {
                $edaColab->f_cerrado = \Carbon\Carbon::now();
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
            $evaluacion1 = $eda->evaluacion;
            $evaluacion2 = $eda->evaluacion2;
            $promedio = ($evaluacion1->promedio + $evaluacion2->promedio);

            $eda->cerrado = true;
            $eda->promedio = $promedio;
            $eda->fecha_cerrado = \Carbon\Carbon::now();
            $eda->save();
            return response()->json(['msg' => 'Eda cerrado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }
}
