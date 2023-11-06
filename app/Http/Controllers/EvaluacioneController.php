<?php

namespace App\Http\Controllers;

use App\Models\Evaluacione;
use Illuminate\Http\Request;

/**
 * Class EvaluacioneController
 * @package App\Http\Controllers
 */
class EvaluacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluaciones = Evaluacione::paginate();

        return view('evaluacione.index', compact('evaluaciones'))
            ->with('i', (request()->input('page', 1) - 1) * $evaluaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $evaluacione = new Evaluacione();
        return view('evaluacione.create', compact('evaluacione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Evaluacione::$rules);

        $evaluacione = Evaluacione::create($request->all());

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluacione created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluacione = Evaluacione::find($id);

        return view('evaluacione.show', compact('evaluacione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evaluacione = Evaluacione::find($id);

        return view('evaluacione.edit', compact('evaluacione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Evaluacione $evaluacione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluacione $evaluacione)
    {
        request()->validate(Evaluacione::$rules);

        $evaluacione->update($request->all());

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluacione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $evaluacione = Evaluacione::find($id)->delete();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluacione deleted successfully');
    }
}
