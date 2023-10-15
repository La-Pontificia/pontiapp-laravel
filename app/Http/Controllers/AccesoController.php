<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use Illuminate\Http\Request;

/**
 * Class AccesoController
 * @package App\Http\Controllers
 */
class AccesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accesos = Acceso::paginate();

        return view('acceso.index', compact('accesos'))
            ->with('i', (request()->input('page', 1) - 1) * $accesos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acceso = new Acceso();
        return view('acceso.create', compact('acceso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Acceso::$rules);

        $acceso = Acceso::create($request->all());

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acceso = Acceso::find($id);

        return view('acceso.show', compact('acceso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acceso = Acceso::find($id);

        return view('acceso.edit', compact('acceso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Acceso $acceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acceso $acceso)
    {
        request()->validate(Acceso::$rules);

        $acceso->update($request->all());

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $acceso = Acceso::find($id)->delete();

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso deleted successfully');
    }







    public function getAccesos($id)
    {
        $accesos = Acceso::where('id_colaborador', $id)->paginate();
        return response()->json($accesos, 200);
    }


    public function updateAcceso(Request $request)
    {
        $modulo = $request->modulo;
        $metodo = $request->metodo;
        $id_colab = $request->id_colab;
        $value = $request->value;

        $acceso = Acceso::where('id_colaborador', $id_colab)->where('modulo', $modulo)->first();
        if ($metodo == 'crear') $acceso->crear = $value;
        if ($metodo == 'editar') $acceso->actualizar = $value;
        if ($metodo == 'eliminar') $acceso->eliminar = $value;
        if ($metodo == 'ver') $acceso->leer = $value;
        $acceso->save();

        return response()->json($acceso, 200);
    }
}
