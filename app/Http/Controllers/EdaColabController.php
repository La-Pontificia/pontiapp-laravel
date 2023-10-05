<?php

namespace App\Http\Controllers;

use App\Models\EdaColab;
use Illuminate\Http\Request;

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
