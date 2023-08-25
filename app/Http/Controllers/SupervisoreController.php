<?php

namespace App\Http\Controllers;

use App\Models\Supervisore;
use Illuminate\Http\Request;

/**
 * Class SupervisoreController
 * @package App\Http\Controllers
 */
class SupervisoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supervisores = Supervisore::paginate();

        return view('supervisore.index', compact('supervisores'))
            ->with('i', (request()->input('page', 1) - 1) * $supervisores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisore = new Supervisore();
        return view('supervisore.create', compact('supervisore'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Supervisore::$rules);

        $supervisore = Supervisore::create($request->all());

        return redirect()->route('supervisores.index')
            ->with('success', 'Supervisore created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supervisore = Supervisore::find($id);

        return view('supervisore.show', compact('supervisore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supervisore = Supervisore::find($id);

        return view('supervisore.edit', compact('supervisore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Supervisore $supervisore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supervisore $supervisore)
    {
        request()->validate(Supervisore::$rules);

        $supervisore->update($request->all());

        return redirect()->route('supervisores.index')
            ->with('success', 'Supervisore updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $supervisore = Supervisore::find($id)->delete();

        return redirect()->route('supervisores.index')
            ->with('success', 'Supervisore deleted successfully');
    }
}
