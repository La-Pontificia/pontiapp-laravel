<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Cuestionario;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Evaluacione;
use App\Models\Feedback;
use App\Models\Objetivo;
use App\Models\Plantilla;
use Illuminate\Http\Request;

class MetaController extends GlobalController
{
    public function index()
    {

        return redirect("/meta/" . $this->getCurrentColab()->id);
    }

    public function colaborador($id_colab)
    {
        $edas = Eda::orderBy('año', 'desc')->get();
        $colaborador = Colaboradore::find($id_colab);

        if (!$colaborador) return view('not-found.index');
        $prior_access = $this->getCurrentColab()->rol == 2;

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($prior_access) {
            $miPerfil = true;
            $suSupervisor = true;
        }

        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equibocación comunicate con un administrador.']);
        }

        return view('meta.colaborador', compact('id_colab', 'edas', 'colaborador', 'miPerfil', 'suSupervisor'));
    }





    public function colaboradorEda($id_colab, $id_eda)
    {

        $prior_access = $this->getCurrentColab()->rol == 2;

        $colaborador = Colaboradore::find($id_colab);
        $edas = Eda::orderBy('año', 'desc')->get();
        $edaSeleccionado = EdaColab::find($id_eda);

        //commons

        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($prior_access) {
            $miPerfil = true;
            $suSupervisor = true;
        }

        $cuestionarioColab = Cuestionario::where('id_eda', $id_eda)->where('de', 'colaborador')->first();
        $cuestionarioSuper = Cuestionario::where('id_eda', $id_eda)->where('de', 'supervisor')->first();



        $plantilla = null;
        if ($miPerfil) {
            $plantilla = Plantilla::where('usando', true)
                ->where('para', 'colaboradores')
                ->first();
        } else {
            $plantilla = Plantilla::where('usando', true)
                ->where('para', 'supervisores')
                ->first();
        }

        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equivocación comunicate con un administrador.']);
        }

        return view('meta.colaboradorEda', compact(
            'id_colab',
            'id_eda',
            'edas',
            'colaborador',
            'edaSeleccionado',
            'miPerfil',
            'suSupervisor',
            'plantilla',
            'cuestionarioColab',
            'cuestionarioSuper'
        ));
    }






    public function colaboradorEdaObjetivos($id_colab, $id_eda)
    {

        $prior_access = $this->getCurrentColab()->rol == 2;

        $colaborador = Colaboradore::find($id_colab);
        $edas = Eda::all();
        $edaSeleccionado = EdaColab::find($id_eda);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();
        $objetivoNewForm = new Objetivo();

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($prior_access) {
            $miPerfil = true;
            $suSupervisor = true;
        }

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

    public function colaboradorEdaEva($id_colab, $id_eda, $n_eva)
    {

        $prior_access = $this->getCurrentColab()->rol == 2;


        $colaborador = Colaboradore::find($id_colab);
        $edas = Eda::all();
        $edaSeleccionado = EdaColab::find($id_eda);
        $objetivos = Objetivo::where('id_eda_colab', $id_eda)->get();
        $objetivoNewForm = new Objetivo();
        $feedback = Feedback::where('id_evaluacion', $n_eva == 1 ? $edaSeleccionado->id_evaluacion : $edaSeleccionado->id_evaluacion_2)->first();

        //commons
        $miPerfil = $this->getCurrentColab()->id == $id_colab ? true : false;
        $suSupervisor = $this->getCurrentColab()->id == $colaborador->id_supervisor ? true : false;

        if ($prior_access) {
            $miPerfil = true;
            $suSupervisor = true;
        }

        if ($suSupervisor == false && $miPerfil == false) {
            return view('meta.commons.errorPage', ['titulo' => 'No autorizado', 'descripcion' => 'No tienes autorizado para acceder a este recurso, si crees que es una equivocación comunicate con un administrador.']);
        }

        $evaluacion = Evaluacione::find($edaSeleccionado->id);

        return view('meta.evaluaciones.index', compact(
            'id_colab',
            'id_eda',
            'edas',
            'colaborador',
            'edaSeleccionado',
            'objetivoNewForm',
            'objetivos',
            'miPerfil',
            'suSupervisor',
            'n_eva',
            'evaluacion',
            'feedback'
        ));
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
        $objetivos = Objetivo::where('id_eda_colab', $objetivo->id_eda_colab);
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

    public function cambiarNota($id, $nota, $nombre_nota, $n_eva)
    {

        $objetivo = Objetivo::find($id);
        if ($n_eva == 1) {
            if ($nombre_nota == 'promedio')  $objetivo->promedio = $nota;
            else $objetivo->autocalificacion = $nota;
        } else {
            if ($nombre_nota == 'promedio')  $objetivo->promedio_2 = $nota;
            else $objetivo->autocalificacion_2 = $nota;
        }
        $objetivo->save();
        return response()->json(['success' => true, "objetivo autocalificado/calificado"], 200);
    }


    public function autocalificarObjetivo(Request $request, $n_eva)
    {
        $id = $request->id;
        $nota = $request->nota;

        if (!$id || !$nota) {
            return response()->json(['error' => 'El id y la nota es requerido'], 404);
        }
        if ($nota != 1 && $nota != 2 && $nota != 3 && $nota != 4 && $nota != 5) {
            return response()->json(['error' => 'La nora debe ser 1, 2, 3, 4 o 5'], 404);
        }
        return $this->cambiarNota($id, $nota, 'autoevaluacion', $n_eva);
    }


    public function calificarObjetivo(Request $request, $n_eva)
    {
        $id = $request->id;
        $nota = $request->nota;

        if (!$id || !$nota) {
            return response()->json(['error' => 'El id y la nota es requerido'], 404);
        }
        if ($nota != 1 && $nota != 2 && $nota != 3 && $nota != 4 && $nota != 5) {
            return response()->json(['error' => 'La nota debe ser 1, 2, 3, 4 o 5'], 404);
        }
        return $this->cambiarNota($id, $nota, 'promedio', $n_eva);
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
