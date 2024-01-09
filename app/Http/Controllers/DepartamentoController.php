<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Auditoria;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends GlobalController
{

    public function index()
    {
        $departamentoForm = new Departamento();
        $departamentos = Departamento::orderBy('codigo', 'asc')->paginate();
        $areas = Area::all();
        return view('departamento.index', compact('departamentos', 'departamentoForm', 'areas'))
            ->with('i', (request()->input('page', 1) - 1) * $departamentos->perPage());
    }


    public function store(Request $request)
    {
        $codeUltimate = Departamento::max('codigo');
        $numero = (int)substr($codeUltimate, 1) + 1;
        $newCode = 'D' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        $validatedData = $request->validate(Departamento::$rules);
        $data = array_merge($validatedData, [
            'codigo' => $newCode,
        ]);
        Departamento::create($data);

        Auditoria::create([
            'id_colab' => $this->getCurrentColab()->id,
            'modulo' => 'departamento',
            'titulo' => 'Se creo un nuevo registro',
            'descripcion' => 'Se creo un departamento ' . $data['nombre'],
        ]);
        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento created successfully.');
    }

    public function update(Request $request, Departamento $departamento)
    {
        request()->validate(Departamento::$rules);
        $exiteCodigo = Departamento::where('codigo', $request->codigo)->first();
        if ($exiteCodigo && $exiteCodigo->id != $departamento->id) {
            return response()->json(['error' => 'Ya hay un registro con en mismo codigo'], 404);
        }

        $departamento->update($request->all());
        Auditoria::create([
            'id_colab' => $this->getCurrentColab()->id,
            'modulo' => 'departamento',
            'titulo' => 'Se actualizo un nuevo registro',
            'descripcion' => 'Se actualizó una departamento ' . $departamento->nombre,
        ]);
        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento updated successfully');
    }
}
