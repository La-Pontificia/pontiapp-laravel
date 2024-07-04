<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;

class EdaController extends Controller
{

    public function create(Request $request)
    {
        $evaluationArray = [1, 2];

        $foundedUser = User::find($request->id_user);
        if (!$foundedUser) return response()->json('El colaborador no existe', 404);

        $foundYear = Year::find($request->id_year);
        if (!$foundYear) return response()->json('La eda selecionado no existe', 404);
        if (!$foundYear->status) return response()->json('El año seleccionado no esta activo', 404);

        if (!auth()->user()->id) return response()->json('No tienes permisos para realizar esta acción', 403);

        $eda = Eda::create([
            'id_user' => $foundedUser->id,
            'id_year' => $foundYear->id,
            'created_by' => auth()->user()->id,
        ]);

        // create evaluations
        foreach ($evaluationArray as $evaluation) {
            Evaluation::create([
                'number' => $evaluation,
                'id_eda' => $eda->id,
            ]);
        }

        return response()->json(['eda' => $eda], 200);
    }

    public function close(Request $request)
    {
        $eda = Eda::find($request->id);

        if (!$eda) return response()->json('La eda no existe', 404);

        if ($eda->closed) return response()->json('La eda ya esta cerrada', 404);

        if (!auth()->user()->id) return response()->json('No tienes permisos para realizar esta acción', 403);

        $eda->closed = now();

        $eda->closed_by = auth()->user()->id;

        $eda->save();

        return response()->json(['eda' => $eda], 200);
    }
}
