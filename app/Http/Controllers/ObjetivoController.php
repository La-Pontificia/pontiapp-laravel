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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objetivo = new Objetivo();
        return view('objetivo.create', compact('objetivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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



    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objetivo = Objetivo::find($id);

        return view('objetivo.show', compact('objetivo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Objetivo $objetivo
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Objetivo $objetivo)
    // {
    //     $colab = $this->getCurrentColab();
    //     if ($request->porcentaje < 1) {
    //         return response()->json(['error' => 'El porcentaje no puede ser menor a 1'], 400);
    //     }

    //     $objetivos = Objetivo::where('id_colaborador', $colab->id)
    //         ->where('id', '!=', $objetivo->id)
    //         ->get();

    //     $totalPorcentaje = $objetivos->sum('porcentaje') + $request->porcentaje;
    //     if ($totalPorcentaje > 100) {
    //         return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
    //     }

    //     $maxTextLength = 2000;
    //     $requiredFields = ['descripcion' => 'La descripción', 'indicadores' => 'Los indicadores'];

    //     foreach ($requiredFields as $field => $fieldName) {
    //         if (!$request->$field || strlen($request->$field) > $maxTextLength) {
    //             return response()->json(['error' => "$fieldName no puede estar vacío o tener más de $maxTextLength caracteres"], 400);
    //         }
    //     }

    //     // Actualizar el objetivo
    //     $objetivo->update($request->all());
    //     return response()->json(['success' => true], 200);
    // }


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





    public function cambiarNota($id, $nota, $nombre_nota)
    {

        if (!$id || !$nota) {
            return response()->json(['error' => 'El id y la nota es requerido'], 404);
        }
        if ($nota != 1 && $nota != 2 && $nota != 3 && $nota != 4 && $nota != 5) {
            return response()->json(['error' => 'La nora debe ser 1, 2, 3, 4 o 5'], 404);
        }

        $objetivo = Objetivo::find($id);
        if ($nombre_nota == 'nota') {
            $objetivo->nota = $nota;
        } else {
            $objetivo->autoevaluacion = $nota;
        }
        $objetivo->save();

        return response()->json(['success' => true, "objetivo autocalificado/calificado"], 200);
    }


    public function autocalificarObjetivo(Request $request)
    {
        $id = $request->id;
        $nota = $request->nota;

        if (!$id || !$nota) {
            return response()->json(['error' => 'El id y la nota es requerido'], 404);
        }
        if ($nota != 1 && $nota != 2 && $nota != 3 && $nota != 4 && $nota != 5) {
            return response()->json(['error' => 'La nora debe ser 1, 2, 3, 4 o 5'], 404);
        }
        return $this->cambiarNota($id, $nota, 'autoevaluacion');
    }


    public function calificarObjetivo(Request $request)
    {
        $id = $request->id;
        $nota = $request->nota;

        if (!$id || !$nota) {
            return response()->json(['error' => 'El id y la nota es requerido'], 404);
        }
        if ($nota != 1 && $nota != 2 && $nota != 3 && $nota != 4 && $nota != 5) {
            return response()->json(['error' => 'La nora debe ser 1, 2, 3, 4 o 5'], 404);
        }
        return $this->cambiarNota($id, $nota, 'nota');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $objetivo = Objetivo::find($id)->delete();

        return redirect()->route('profile.me')
            ->with('success', 'Objetivo deleted successfully');
    }
}
