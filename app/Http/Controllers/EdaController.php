<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\EdaColab;
use Illuminate\Http\Request;

/**
 * Class EdaController
 * @package App\Http\Controllers
 */
class EdaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edas = Eda::paginate();
        $newEda = new Eda();
        return view('eda.index', compact('edas', 'newEda'))
            ->with('i', (request()->input('page', 1) - 1) * $edas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eda = new Eda();
        return view('eda.create', compact('eda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Realizar las validaciones personalizadas aquí
        $year = $request->input('year');
        $numero = $request->input('n_evaluacion');

        // Realiza las validaciones
        if ($this->validarEdaExistente($year, $numero)) {
            return response()->json(['message' => 'Ya existe un registro con el mismo año y número'], 202);
        }

        $wearing = $request->wearing === 'on' ? 1 : 0;
        $request->merge(['wearing' => $wearing]);

        request()->validate(Eda::$rules);

        $eda = Eda::create($request->all());
        if ($wearing === 1) Eda::where('id', '<>', $eda->id)->update(['wearing' => 0]);

        $this->createEdaByColab($eda->id, $wearing);
        return response()->json(['success' => true], 202);
    }


    private function validarEdaExistente($year, $numero)
    {
        $edaExistente = Eda::where('year', $year)
            ->where('n_evaluacion', $numero)
            ->first();

        return $edaExistente !== null;
    }


    public function changeWearing($id)
    {
        // Primero, establecemos wearing = 0 para todos los registros
        Eda::where('id', '<>', $id)->update(['wearing' => 0]);

        // Luego, establecemos wearing = 1 para el registro específico
        $eda = Eda::findOrFail($id);
        $eda->wearing = 1;
        $eda->save();

        $this->changeEdaWearingByColab($eda->id);

        return response()->json(['success' => true], 200);
    }

    public function createEdaByColab($id_eda, $wearing)
    {
        $colaboradores = Colaboradore::get();
        foreach ($colaboradores as $colaborador) {
            EdaColab::create([
                'id_eda' => $id_eda,
                'id_colaborador' => $colaborador->id,
                'wearing' => $wearing,
                'estado' => 0, // 0 PENDIENTE | 1 ENVIADO | 2 APROBADO | 3 CERRADO
                'cant_obj' => 0,
                'nota_final' => 0,
            ]);
        }
    }

    public function changeEdaWearingByColab($id_eda)
    {
        EdaColab::where('id_eda', '<>', $id_eda)->update(['wearing' => 0]);
        EdaColab::where('id_eda', $id_eda)->update(['wearing' => 1]);

        $colaboradores = Colaboradore::all(); // Obtén todos los colaboradores
        foreach ($colaboradores as $colaborador) {
            $colaborador->update(['id_eda_colab' => $id_eda]); // Actualiza el campo id_eda para cada colaborador
        }
    }

    // public function createEdaByColab($id_eda)
    // {
    //     $colaboradores = Colaboradore::get();
    //     foreach ($colaboradores as $colaborador) {
    //         EdaColab::create([
    //             'id_eda' => $id_eda,
    //             'id_colaborador' => $colaborador->id,
    //             // 'wearing' => 1,
    //             'estado' => 0, // 0 PENDIENTE | 1 ENVIADO | 2 APROBADO | 3 CERRADO
    //             'cant_obj' => 0,
    //             'nota_final' => 0,
    //         ]);
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eda = Eda::find($id);

        return view('eda.show', compact('eda'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eda = Eda::find($id);

        return view('eda.edit', compact('eda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Eda $eda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eda $eda)
    {
        request()->validate(Eda::$rules);
        $eda->update($request->all());
        return redirect()->route('edas.index')
            ->with('success', 'Eda updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $eda = Eda::find($id);
        if ($eda && $eda->wearing === 1) {
            $ultimoEda = Eda::where('id', '<>', $eda->id)->orderBy('created_at', 'desc')->first();
            if ($ultimoEda) {
                $ultimoEda->update(['wearing' => 1]);
            }
        }

        if ($eda) {
            $eda->delete();
        }

        return redirect()->route('edas.index')
            ->with('success', 'Eda deleted successfully');
    }
}
