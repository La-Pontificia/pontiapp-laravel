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
            $autocalificacion = 0;
            $promedio = 0;
            $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();

            foreach ($objetivos as $objetivo) {
                $pro = $n_eva == 1 ?  $objetivo['promedio'] : $objetivo['promedio_2'];
                $nota =  $pro * ($objetivo['porcentaje'] / 100);
                $autocalificacion += $objetivo['autocalificacion'];
                $promedio += $nota;
            }

            $promedioRedondeado = round($promedio);

            $evaluacion = Evaluacione::find($id);
            $evaluacion->autocalificacion = $autocalificacion;
            $evaluacion->promedio = $promedioRedondeado;
            $evaluacion->cerrado = true;
            $evaluacion->fecha_cerrado = date('Y-m-d H:i:s');
            $evaluacion->save();
            return response()->json([
                'message' => 'Evaluacione cerrada con exito',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
