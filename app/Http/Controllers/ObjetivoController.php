<?php

namespace App\Http\Controllers;

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
        $colab = $this->getCurrentColab();

        if ($request->porcentaje < 1) {
            return response()->json(['error' => 'El porcentaje no puede ser menor a 0'], 400);
        }

        // Valida los datos del formulario
        $validatedData = $request->validate(Objetivo::$rules);
        $objetivos = $this->getObjetivosByCurrentColab();
        $totalPorcentaje = $objetivos->sum('porcentaje');

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }

        // obtenemos el supervisor del colaborador
        $super = $this->getSuperByCurrentColab();

        $edaColab = $this->getCurrentEdaByCurrentColab();
        // creamos una nueva data
        $data = array_merge($validatedData, [
            'id_eda_colab' => $edaColab->id,
            'id_supervisor' => $super->id_supervisor,
            'porcentaje' =>  $request->input('porcentaje'),
            'porcentaje_inicial' => $request->input('porcentaje')
        ]);

        // Crea un nuevo Objetivo con los datos combinados
        Objetivo::create($data);
        return response()->json(['success' => true], 202);
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
    public function update(Request $request, Objetivo $objetivo)
    {



        $colab = $this->getCurrentColab();
        $validatedData = $request->validate(Objetivo::$rules);
        if ($request->porcentaje < 1) {
            return response()->json(['error' => 'El porcentaje no puede ser menor a 0'], 400);
        }
        $objetivos = Objetivo::where('id_colaborador', $colab->id)->where('id', '!=', $objetivo->id)->get();
        $totalPorcentaje = $objetivos->sum('porcentaje') + $validatedData['porcentaje'];

        if ($totalPorcentaje > 100) {
            return response()->json(['error' => 'La suma total de porcentaje excede 100'], 400);
        }

        $objetivo->update($request->all());
        return response()->json(['success' => true], 200);
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
