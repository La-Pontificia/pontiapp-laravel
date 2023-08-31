<?php

namespace App\Http\Controllers;

use App\Models\Notificacione;
use Illuminate\Http\Request;

/**
 * Class NotificacioneController
 * @package App\Http\Controllers
 */
class NotificacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notificaciones = Notificacione::paginate();

        return view('notificacione.index', compact('notificaciones'))
            ->with('i', (request()->input('page', 1) - 1) * $notificaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notificacione = new Notificacione();
        return view('notificacione.create', compact('notificacione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Notificacione::$rules);

        $notificacione = Notificacione::create($request->all());

        return redirect()->route('notificaciones.index')
            ->with('success', 'Notificacione created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notificacione = Notificacione::find($id);

        return view('notificacione.show', compact('notificacione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notificacione = Notificacione::find($id);

        return view('notificacione.edit', compact('notificacione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Notificacione $notificacione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacione $notificacione)
    {
        request()->validate(Notificacione::$rules);

        $notificacione->update($request->all());

        return redirect()->route('notificaciones.index')
            ->with('success', 'Notificacione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $notificacione = Notificacione::find($id)->delete();

        return redirect()->route('notificaciones.index')
            ->with('success', 'Notificacione deleted successfully');
    }
}
