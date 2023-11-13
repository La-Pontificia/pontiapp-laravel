<?php

namespace App\Http\Controllers;

use App\Models\Evaluacione;
use Illuminate\Http\Request;

/**
 * Class EvaluacioneController
 * @package App\Http\Controllers
 */
class EvaluacioneController extends Controller
{
    public function cerrar($id)
    {
        try {
            $evaluacione = Evaluacione::find($id);
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
