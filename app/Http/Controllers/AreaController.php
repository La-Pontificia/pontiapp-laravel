<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Area;
use App\Models\Auditoria;
use App\Models\Colaboradore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AreaController extends GlobalController
{

    public function index()
    {

        $areas = Area::orderBy('codigo', 'asc')->paginate();
        $area = new Area();
        return view('area.index', compact('areas', 'area'))
            ->with('i', (request()->input('page', 1) - 1) * $areas->perPage());
    }

    public function store(Request $request)
    {
        $codeUltimate = Area::max('codigo');
        $numero = (int)substr($codeUltimate, 1) + 1;
        $newCode = 'A' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        $validatedData = $request->validate(Area::$rules);

        // creamos el area
        $data = array_merge($validatedData, [
            'codigo' => $newCode,
        ]);

        Auditoria::create([
            'id_colab' => $this->getCurrentColab()->id,
            'modulo' => 'area',
            'titulo' => 'Se creo un nuevo registro',
            'descripcion' => 'Se creó una area ' . $data['nombre'],
        ]);

        Area::create($data);
        return redirect()->route('areas.index')
            ->with('success', 'Area created successfully.');
    }

    public function update(Request $request, Area $area)
    {
        request()->validate(Area::$rules);
        $exiteCodigo = Area::where('codigo', $request->codigo)->first();
        if ($exiteCodigo && $exiteCodigo->id != $area->id) {
            return response()->json(['error' => 'Ya hay un registro con en mismo codigo'], 404);
        }
        $area->update($request->all());

        Auditoria::create([
            'id_colab' => $this->getCurrentColab()->id,
            'modulo' => 'area',
            'titulo' => 'Se actualizó un registro',
            'descripcion' => 'Se actualizó un registro con el id ' . $area->id,
        ]);

        return redirect()->route('areas.index')
            ->with('success', 'Area updated successfully');
    }
}
