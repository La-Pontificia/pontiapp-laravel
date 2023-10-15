<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PuestoController
 * @package App\Http\Controllers
 */
class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $puesto = new Puesto();
       $puestos = Puesto::paginate();
       $cargos = Cargo::all();
       $departamentos = Departamento::all();
        return view('puesto.index', compact('puestos', 'puesto', 'cargos','departamentos'))
            ->with('i', (request()->input('page', 1) - 1) * $puestos->perPage());
    }


    public function getPuestosByArea($id_cargo)
    {
        $puestos = Puesto::where('id_cargo', $id_cargo)->get();
        return $puestos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $puesto = new Puesto();
        return view('puesto.create', compact('puesto', 'cargos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     // obtenemos el ultimo codigo de puesto
     $codeUltimate = Puesto::max('codigo_puesto');

     // creamos el nuevo codigo
     $numero = (int)substr($codeUltimate, 1) + 1;
     $newCode = 'P' . str_pad($numero, 3, '0', STR_PAD_LEFT);

     // validamos los datos
     $validatedData = $request->validate(Puesto::$rules);

     // creamos el puesto
     $data = array_merge($validatedData, [
        'codigo_puesto' => $newCode,
    ]);
    Puesto::create($data);

    return redirect()->route('puestos.index')
        ->with('success', 'Puesto created successfully.');
}

        
    

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puesto = Puesto::find($id);

        return view('puesto.show', compact('puesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $puesto = Puesto::find($id);
        $depas = Departamento::pluck('nombre_departamento', 'id');
        return view('puesto.edit', compact('puesto', 'depas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Puesto $puesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Puesto $puesto)
    {
        request()->validate(Puesto::$rules);

        $puesto->update($request->all());

        return redirect()->route('puestos.index')
            ->with('success', 'Puesto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $puesto = Puesto::find($id)->delete();

        return redirect()->route('puestos.index')
            ->with('success', 'Puesto deleted successfully');
    }
}
