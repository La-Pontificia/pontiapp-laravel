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
        $puestoForm = new Puesto();
        $puestos = Puesto::paginate();
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        return view('puesto.index', compact('puestos', 'puestoForm', 'cargos', 'departamentos'))
            ->with('i', (request()->input('page', 1) - 1) * $puestos->perPage());
    }


    public function getPuestosByArea($id_cargo)
    {
        $puestos = Puesto::where('id_cargo', $id_cargo)->get();
        return $puestos;
    }

    public function store(Request $request)
    {
        $codeUltimate = Puesto::max('codigo');
        $numero = (int)substr($codeUltimate, 1) + 1;
        $newCode = 'P' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        $validatedData = $request->validate(Puesto::$rules);
        $data = array_merge($validatedData, [
            'codigo' => $newCode,
        ]);
        Puesto::create($data);
        return redirect()->route('puestos.index')
            ->with('success', 'Puesto created successfully.');
    }

    public function update(Request $request, Puesto $puesto)
    {
        request()->validate(Puesto::$rules);
        $exiteCodigo = Puesto::where('codigo', $request->codigo)->first();
        if ($exiteCodigo && $exiteCodigo->id != $puesto->id) {
            return response()->json(['error' => 'Ya hay un registro con en mismo codigo'], 404);
        }
        $puesto->update($request->all());
        return redirect()->route('puestos.index')
            ->with('success', 'Puesto updated successfully');
    }
}
