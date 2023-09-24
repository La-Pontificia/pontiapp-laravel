<?php

namespace App\Http\Controllers;

use App\Models\Objetivo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalificarController extends Controller
{

    public function desabrobar(Request $request)
    {
        $request->validate([
            'feedback' => 'string|max:255',
            'id' => 'required|integer|min:1',

        ]);

        $objetivo = Objetivo::find($request->id);

        if (!$objetivo) {
            return redirect()->route('objetivo.calificar')->with('error', 'El objetivo no existe.');
        }

        $objetivo->feedback = $request->feedback;
        $objetivo->feedback_fecha = Carbon::now();
        $objetivo->notify_super = 0;
        $objetivo->notify_colab = 1;

        $objetivo->save();

        return redirect()->route('objetivo.calificar')
            ->with('success', 'Objetivo actualizado correctamente.');
    }
}
