<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\Puesto;
use Illuminate\Http\Request;


class CargoController extends Controller
{

    public function index()
    {
        $cargos = Cargo::paginate();
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $cargoForm = new Cargo();
        return view('cargo.index', compact('cargos', 'cargoForm', 'puestos', 'departamentos'))
            ->with('i', (request()->input('page', 1) - 1) * $cargos->perPage());
    }

    public function byPuesto($id_puesto)
    {
        $cargos = Cargo::where('id_puesto', $id_puesto)->get();
        return response()->json($cargos);
    }

    public function store(Request $request)
    {
        $codeUltimate = Cargo::max('codigo');
        $numero = (int)substr($codeUltimate, 1) + 1;
        $newCode = 'C' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        $validatedData = $request->validate(Cargo::$rules);
        $data = array_merge($validatedData, [
            'codigo' => $newCode,
        ]);
        Cargo::create($data);
        return redirect("/cargos");
    }





    public function update(Request $request, Cargo $cargo)
    {
        request()->validate(Cargo::$rules);
        $exiteCodigo = Cargo::where('codigo', $request->codigo)->first();
        if ($exiteCodigo && $exiteCodigo->id != $cargo->id) {
            return response()->json(['error' => 'Ya hay un registro con en mismo codigo'], 404);
        }

        $cargo->update($request->all());
        return redirect()->route('cargos.index')
            ->with('success', 'Cargo updated successfully');
    }
}
