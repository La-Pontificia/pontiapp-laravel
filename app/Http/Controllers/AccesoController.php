<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Colaboradore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $modulos = ['Colaboradores', 'Departamento', 'Areas', 'Puestos', 'Cargos', 'Objetivos', 'Acessos', 'Usuarios'];
        $accesos = ['0', '1'];
        $colabs = Colaboradore::pluck('nombres', 'id');
        $acceso = new Acceso();
        return view('acceso.create', compact('acceso', 'modulos', 'accesos', 'colabs'));
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

    public function disableAccess(Request $request, $id)
    {
        $acceso = Acceso::findOrFail($id);
        $acceso->acceso = $acceso->acceso == 0 ? 1 : 0; // Cambiar de 0 a 1 y viceversa
        $acceso->save();

        if ($request->ajax()) {
            // Devuelve el estado actualizado y la clase CSS del botón
            $response = [
                'acceso' => $acceso->acceso == 0 ? 1 : 0,
                'success' => 'Estado de acceso cambiado exitosamente.'
            ];

            return response()->json($response);
        }


        return redirect()->route('accesos.index')
            ->with('success', 'Estado de acceso cambiado exitosamente.');
    }
    public function getAccesosColaborador($id)
    {
        $colaborador = Colaboradore::find($id);

        if (!$colaborador) {
            abort(404);
        }

        $accesos = Acceso::where('id_colaborador', $colaborador->id)->paginate();

        // Reutiliza la vista 'acceso.index' y la lógica de paginación
        return view('acceso.index', compact('accesos'))
            ->with('i', (request()->input('page', 1) - 1) * $accesos->perPage());
    }

    public function edit($id)
    {
        $acceso = Acceso::find($id);
        $modulos = ['Colaboradores', 'Departamento', 'Areas', 'Puestos', 'Cargos', 'Objetivos', 'Acessos', 'Usuarios'];
        $accesos = ['0', '1'];
        $colabs = Colaboradore::pluck('nombres', 'id');
        return view('acceso.edit', compact('acceso', 'modulos', 'accesos', 'colabs'));
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
}
