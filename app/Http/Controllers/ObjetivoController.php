<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Objetivo;
use App\Models\Supervisore;
use Illuminate\Http\Request;

/**
 * Class ObjetivoController
 * @package App\Http\Controllers
 */
class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objetivos = Objetivo::paginate();
        $objetivoNewForm = new Objetivo();
        return view('objetivo.index', compact('objetivos', 'objetivoNewForm'))
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
        // Valida los datos del formulario
        $validatedData = $request->validate(Objetivo::$rules);

        $user = auth()->user();
        if (!$user) {
            abort(404);
        }
        $id = $user->id;

        // obtenemos el colaborador por id de usuario
        $colab = Colaboradore::where([
            'id_usuario' => $id,
        ])->first();

        if (!$colab) {
            abort(404);
        }

        // obtenemos el supervisor del colaborador
        $super = Supervisore::where('id_colaborador', $colab->id)->first();


        if (!$super) {
            abort(404);
        }

        // creamos una nueva data
        $data = array_merge($validatedData, [
            'id_colaborador' => $colab->id,
            'id_supervisor' => $super->id,
            'estado' => 1,
            'eva' => 1,
            'año' => '2023',
            'notify_super' => 1,
            'notify_colab' => 0,
        ]);


        // Crea un nuevo Objetivo con los datos combinados
        $objetivo = Objetivo::create($data);

        return redirect()->route('objetivos.index')
            ->with('success', 'Objetivo creado correctamente');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Objetivo $objetivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objetivo $objetivo)
    {
        request()->validate(Objetivo::$rules);

        $objetivo->update($request->all());

        return redirect()->route('objetivos.index')
            ->with('success', 'Objetivo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $objetivo = Objetivo::find($id)->delete();

        return redirect()->route('objetivos.index')
            ->with('success', 'Objetivo deleted successfully');
    }
}
