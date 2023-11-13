<?php

namespace App\Http\Controllers;

use App\Models\Evaluacione;
use App\Models\Objetivo;

/**
 * Class EvaluacioneController
 * @package App\Http\Controllers
 */
class EvaluacioneController extends Controller
{
    public function cerrar($id, $id_eda, $n_eva)
    {


        try {
            $objetivos = Objetivo::where('id_eda_colab', $id_eda);
            $autocalificacion =  $n_eva == 1 ? $objetivos->sum('autocalificacion') : $objetivos->sum('autocalificacion_2');
            $promedio =  $n_eva == 1 ? $objetivos->sum('promedio') : $objetivos->sum('promedio_2');
            $evaluacione = Evaluacione::find($id);
            $evaluacione->autocalificacion = $autocalificacion;
            $evaluacione->promedio = $promedio;
            $evaluacione->cerrado = true;
            $evaluacione->fecha_cerrado = date('Y-m-d H:i:s');
            $evaluacione->save();
            return response()->json([
                'message' => 'Evaluacione cerrada con exito'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
