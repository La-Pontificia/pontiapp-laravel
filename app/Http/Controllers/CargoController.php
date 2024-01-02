<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Cargo;
use App\Models\Colaboradore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CargoController
 * @package App\Http\Controllers
 */
class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_puesto)
    {
        $cargos = Cargo::paginate();
        $cargo = new Cargo();


        return view('cargo.index', compact('cargos', 'cargo'))
            ->with('i', (request()->input('page', 1) - 1) * $cargos->perPage());
    }

    public function byPuesto($id_puesto)
    {
        $cargos = Cargo::where('id_puesto', $id_puesto)->get();
        $data = $cargos->map(function ($cargo, $index) {
            $item = [
                'index' => $index,
                'id' => $cargo->id,
                'nombre' => $cargo->nombre,
            ];
            return $item;
        });
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cargo = new Cargo();
        return view('cargo.create', compact('cargo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $codeUltimate = Cargo::max('codigo_cargo');

        // creamos el nuevo codigo
        $numero = (int)substr($codeUltimate, 1) + 1;
        $newCode = 'C' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        $validatedData = $request->validate(Cargo::$rules);

        // creamos el cargo
        $data = array_merge($validatedData, [
            'codigo_cargo' => $newCode,
        ]);

        Cargo::create($data);

        return redirect("/cargos");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::find($id);

        return view('cargo.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cargo = Cargo::find($id);

        return view('cargo.edit', compact('cargo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargo $cargo)
    {
        request()->validate(Cargo::$rules);

        $cargo->update($request->all());

        return redirect()->route('cargos.index')
            ->with('success', 'Cargo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cargo = Cargo::find($id)->delete();

        return redirect()->route('cargos.index')
            ->with('success', 'Cargo deleted successfully');
    }
}
