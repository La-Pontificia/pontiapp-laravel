<?php

namespace App\Http\Controllers;

use App\Models\EdaColab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

/**
 * Class EdaColabController
 * @package App\Http\Controllers
 */
class EdaColabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edaColabs = EdaColab::paginate();

        return view('eda-colab.index', compact('edaColabs'))
            ->with('i', (request()->input('page', 1) - 1) * $edaColabs->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edaColab = new EdaColab();
        return view('eda-colab.create', compact('edaColab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(EdaColab::$rules);

        $edaColab = EdaColab::create($request->all());

        return redirect()->route('eda-colabs.index')
            ->with('success', 'EdaColab created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $edaColab = EdaColab::find($id);

        return view('eda-colab.show', compact('edaColab'));
    }


    public function defineFLimiteEnvio(Request $request)
    {
        $edaColab = EdaColab::find($request->id);
        $edaColab->flimit_send_obj_from = $request->flimit_send_obj_from;
        $edaColab->flimit_send_obj_at = $request->flimit_send_obj_at;
        $edaColab->save();
        return response()->json(['success' => true], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edaColab = EdaColab::find($id);

        return view('eda-colab.edit', compact('edaColab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  EdaColab $edaColab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EdaColab $edaColab)
    {
        request()->validate(EdaColab::$rules);

        $edaColab->update($request->all());

        return redirect()->route('eda-colabs.index')
            ->with('success', 'EdaColab updated successfully');
    }


    public function cambiarEstado(Request $request)
    {

        $id = $request->id;
        $estado = $request->estado;

        if (!$id || !$estado) {
            return response()->json(['error' => 'El id y el estado es requerido'], 404);
        }
        if ($estado != 1 && $estado != 2 && $estado != 3 && $estado != 4) {
            return response()->json(['error' => 'El estado debe ser 1, 2, 3 o 4'], 404);
        }

        try {
            $edaColab = EdaColab::find($id);
            $edaColab->estado = $estado;
            if ($estado == 1) {
                $edaColab->f_envio = \Carbon\Carbon::now();
            } elseif ($estado == 2) {
                $edaColab->f_aprobacion = \Carbon\Carbon::now();
            } elseif ($estado == 3) {
                $edaColab->f_autocalificacion = \Carbon\Carbon::now();
            } elseif ($estado == 4) {
                $edaColab->f_cerrado = \Carbon\Carbon::now();
            }
            $edaColab->save();
            return response()->json(['msg' => 'Estado cambiado'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Eda no encontrado'], 404);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $edaColab = EdaColab::find($id)->delete();

        return redirect()->route('eda-colabs.index')
            ->with('success', 'EdaColab deleted successfully');
    }
}
