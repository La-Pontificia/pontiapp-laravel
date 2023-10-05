<?php

namespace App\Http\Controllers;

use App\Models\EdaObj;
use Illuminate\Http\Request;

/**
 * Class EdaObjController
 * @package App\Http\Controllers
 */
class EdaObjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edaObjs = EdaObj::paginate();

        return view('eda-obj.index', compact('edaObjs'))
            ->with('i', (request()->input('page', 1) - 1) * $edaObjs->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edaObj = new EdaObj();
        return view('eda-obj.create', compact('edaObj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(EdaObj::$rules);

        $edaObj = EdaObj::create($request->all());

        return redirect()->route('eda-objs.index')
            ->with('success', 'EdaObj created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $edaObj = EdaObj::find($id);

        return view('eda-obj.show', compact('edaObj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edaObj = EdaObj::find($id);

        return view('eda-obj.edit', compact('edaObj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  EdaObj $edaObj
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EdaObj $edaObj)
    {
        request()->validate(EdaObj::$rules);

        $edaObj->update($request->all());

        return redirect()->route('eda-objs.index')
            ->with('success', 'EdaObj updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $edaObj = EdaObj::find($id)->delete();

        return redirect()->route('eda-objs.index')
            ->with('success', 'EdaObj deleted successfully');
    }
}
