<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\EdaColab;
use App\Models\Objetivo;
use Illuminate\Http\Request;

class MetaController extends GlobalController
{
    public function index()
    {
        return view('meta.index');
    }

    public function colaborador($id_colab)
    {
        $edas = EdaColab::where('id_colaborador', $id_colab)->orderBy('created_at', 'desc')->get();
        return view('meta.colaborador', compact('id_colab', 'edas'));
    }

    public function colaboradorEda($id_colab, $id_eda)
    {
        $colaborador = Colaboradore::find($id_colab);
        $edas = EdaColab::where('id_colaborador', $id_colab)->orderBy('created_at', 'desc')->get();
        $edaSeleccionado = EdaColab::find($id_eda);
        return view('meta.colaboradorEda', compact('id_colab', 'id_eda', 'edas', 'colaborador', 'edaSeleccionado'));
    }

    public function colaboradorEdaObjetivos($id_colab, $id_eda)
    {
        $colaborador = Colaboradore::find($id_colab);
        $edas = EdaColab::where('id_colaborador', $id_colab)->orderBy('created_at', 'desc')->get();
        $edaSeleccionado = EdaColab::find($id_eda);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();
        $objetivoNewForm = new Objetivo();

        return view('meta.objetivos.index', compact('id_colab', 'id_eda', 'edas', 'colaborador', 'edaSeleccionado', 'objetivoNewForm', 'objetivos'));
    }

    public function colaboradorEdaEva($id_colab, $id_eda, $id_eva)
    {
        return view('meta.colaboradorEdaEva', compact('id_colab', 'id_eda', 'id_eva'));
    }


    // ---------------------------------OBJETIVOS--------------------------------

    public function agregarObjetivo(Request $request, $id_colab, $id_eda)
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

        $objetivos = Objetivo::where('id_eda_colab', $id_eda);
        $totalPorcentaje = $objetivos->sum('porcentaje') + $request->porcentaje;

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }

        // Crear el nuevo objetivo
        $data = array_merge($validatedData, [
            'id_eda_colab' => $id_eda,
            'porcentaje' =>  $request->input('porcentaje'),
        ]);

        Objetivo::create($data);
        return response()->json(['success' => true], 202);
    }

    public function eliminarObjetivo($id_objetivo)
    {
        try {
            $objetivo = Objetivo::findOrFail($id_objetivo);
            $objetivo->delete();
            return response()->json(['msg' => 'Objetivo eliminado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Objetivo no encontrado'], 404);
        }
    }
}
