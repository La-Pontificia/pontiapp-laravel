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

        $colaborador = Colaboradore::find($id_colab);

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;


        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equibocación comunicate con un administrador.']);
        }

        return view('meta.colaborador', compact('id_colab', 'edas', 'colaborador'));
    }

    public function colaboradorEda($id_colab, $id_eda)
    {
        $colaborador = Colaboradore::find($id_colab);
        $edas = EdaColab::where('id_colaborador', $id_colab)->orderBy('created_at', 'desc')->get();
        $edaSeleccionado = EdaColab::find($id_eda);

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equivocación comunicate con un administrador.']);
        }

        return view('meta.colaboradorEda', compact('id_colab', 'id_eda', 'edas', 'colaborador', 'edaSeleccionado', 'miPerfil'));
    }






    public function colaboradorEdaObjetivos($id_colab, $id_eda)
    {
        $colaborador = Colaboradore::find($id_colab);
        $edas = EdaColab::where('id_colaborador', $id_colab)->orderBy('created_at', 'desc')->get();
        $edaSeleccionado = EdaColab::find($id_eda);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();
        $objetivoNewForm = new Objetivo();

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equivocación comunicate con un administrador.']);
        }

        return view('meta.objetivos.index', compact(
            'id_colab',
            'id_eda',
            'edas',
            'colaborador',
            'edaSeleccionado',
            'objetivoNewForm',
            'objetivos',
            'miPerfil',
            'suSupervisor'
        ));
    }

    public function colaboradorEdaEva($id_colab, $id_eda, $id_eva)
    {
        return view('meta.colaboradorEdaEva', compact('id_colab', 'id_eda', 'id_eva'));
    }


    // ---------------------------------OBJETIVOS--------------------------------

    public function agregarObjetivo(Request $request, $id_colab, $id_eda)
    {
        if ($request->porcentaje < 1 || $request->porcentaje > 100) {
            return response()->json(['error' => 'El porcentaje debe estar entre 1 y 100'], 400);
        }
        $maxTextLength = 2000;
        $requiredFields = ['descripcion' => 'La descripción', 'indicadores' => 'Los indicadores'];
        foreach ($requiredFields as $field => $fieldName) {
            if (!$request->$field || strlen($request->$field) > $maxTextLength) {
                return response()->json(['error' => "$fieldName no puede estar vacío o tener más de $maxTextLength caracteres"], 400);
            }
        }
        $validatedData = $request->validate(Objetivo::$rules);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda);
        $totalPorcentaje = $objetivos->sum('porcentaje') + $request->porcentaje;
        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }
        $data = array_merge($validatedData, [
            'id_eda_colab' => $id_eda,
            'porcentaje' =>  $request->input('porcentaje'),
        ]);
        Objetivo::create($data);
        return response()->json(['success' => true], 202);
    }

    public function actualizarObjetivo(Request $request, $id_colab, $id_eda, $id_objetivo)
    {
        if ($request->porcentaje < 1 || $request->porcentaje > 100) {
            return response()->json(['error' => 'El porcentaje debe estar entre 1 y 100'], 400);
        }
        $maxTextLength = 2000;
        $requiredFields = ['descripcion' => 'La descripción', 'indicadores' => 'Los indicadores'];
        foreach ($requiredFields as $field => $fieldName) {
            if (!$request->$field || strlen($request->$field) > $maxTextLength) {
                return response()->json(['error' => "$fieldName no puede estar vacío o tener más de $maxTextLength caracteres"], 400);
            }
        }
        $objetivo = Objetivo::find($id_objetivo);
        $objetivos = Objetivo::where('id_eda_colab', $id_colab);
        $totalPorcentaje = ($objetivos->sum('porcentaje') - $objetivo->porcentaje) + $request->porcentaje;
        $edaColab = EdaColab::find($id_eda);

        if ($edaColab->enviado == true) $objetivo->editado = 1;

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }
        $objetivo->update($request->all());
        return response()->json(['success' => true], 200);
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




    // -------------------------------EDAS----------------------------------------

    public function cambiarEstadoEda(Request $request, $id_eda)
    {
        $estado = $request->estado;
        if (!$id_eda || !$estado)
            return response()->json(['error' => 'El id y el estado es requerido'], 404);
        if ($estado != 1 && $estado != 2 && $estado != 3)
            return response()->json(['error' => 'El estado debe ser 1, 2, o 3'], 404);

        // 1 = enviado, 2 = aprobado, 3 = cerrado
        try {
            $edaColab = EdaColab::find($id_eda);
            if ($estado == 1) {
                $edaColab->enviado = true;
                $edaColab->fecha_envio = \Carbon\Carbon::now();
            } elseif ($estado == 2) {
                $edaColab->aprobado = true;
                $edaColab->fecha_aprobado = \Carbon\Carbon::now();
            } else {
                $edaColab->cerrado = true;
                $edaColab->fecha_cerrado = \Carbon\Carbon::now();
            }
            $edaColab->save();
            return response()->json(['msg' => 'Estado cambiado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }
}
