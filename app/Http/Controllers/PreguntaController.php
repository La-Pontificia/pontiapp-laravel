<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

/**
 * Class PreguntaController
 * @package App\Http\Controllers
 */
class PreguntaController extends Controller
{
    public function crear(Request $request)
    {
        try {
            $validatedData = $request->validate(Pregunta::$rules);
            $data = array_merge($validatedData);
            Pregunta::create($data);
            return response()->json(['success' => true], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e], 400);
        }
    }

    public function eliminar($id)
    {
        if (is_numeric($id)) {
            try {
                $pregunta = Pregunta::findOrFail($id);
                $pregunta->delete();
                return response()->json(['success' => true], 202);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => $e], 400);
            }
        }
    }
}
