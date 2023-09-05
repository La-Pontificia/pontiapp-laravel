<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Notificacione;
use App\Models\Objetivo;
use App\Models\Supervisore;
use Carbon\Carbon;
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
        $user = auth()->user();
        if (!$user) {
            abort(404);
        }

        $colab = Colaboradore::where('id_usuario', $user->id)->first();
        if (!$colab) {
            abort(404);
        }

        $currentYear = date('Y');
        $years = range(2010, $currentYear);

        $objetivos = Objetivo::where('id_colaborador', $colab->id)->paginate();
        // Crea una nueva instancia de Objetivo para el formulario

        // Verifica si hay objetivos no aprobados
        $objetivosNoAprobados = $objetivos->where('aprobado', 0)->count();

        // Decide si mostrar o no el formulario en función de la condición
        $mostrarFormulario = $objetivosNoAprobados === 0;

        $objetivoForm = new Objetivo();
        // dd($mostrarFormulario);

        return view('objetivo.index', compact('objetivos', 'objetivoForm', 'years', 'mostrarFormulario'))
            ->with('i', ($objetivos->currentPage() - 1) * $objetivos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentYear = date('Y');
        $years = range(2010, $currentYear);

        $objetivo = new Objetivo();
        return view('objetivo.create', compact('objetivo', 'years'));
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
        $colab = Colaboradore::where([
            'id_usuario' => $id,
        ])->first();

        // Calcula la fecha de vencimiento 6 meses en el futuro
        $fecha_vencimiento = Carbon::now()->addMonths(6);

        // Combina los valores predeterminados con los datos del formulario validados
        $data = array_merge($validatedData, [
            'id_colaborador' => $colab->id,
            'fecha_vencimiento' => $fecha_vencimiento,

            'puntaje_01' => 0,
            'fecha_calificacion_1' => null,

            'puntaje_02' => 0,
            'fecha_calificacion_2' => null,

            'aprovado_ev_1' => 0,
            'fecha_aprobacion_1' => null,

            'aprovado_ev_2' => 0,
            'fecha_aprobacion_2' => null,

            'aprobado' => 0,
            'año_actividad' => null,
        ]);


        // Crea un nuevo Objetivo con los datos combinados
        $objetivo = Objetivo::create($data);


        $super = Supervisore::where([
            'id_colaborador' => $colab->id,
        ])->first();

        // Crea una notificación
        $notificacion = new Notificacione([
            'id_colaborador' => $super->id_supervisor,
            'id_objetivo' => $objetivo->id,
            'mensaje' => 'Nuevo objetivo creado: ' . $objetivo->objetivo,
        ]);

        $notificacion->save();

        return redirect()->route('objetivos.index')
            ->with('success', 'Objetivo created successfully.');
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
