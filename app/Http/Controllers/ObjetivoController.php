<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Objetivo;
use App\Models\Puesto;
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

        $id = $user->id;

        // obtenemos el colaborador por id de usuario
        $colab = Colaboradore::where([
            'id_usuario' => $id,
        ])->first();

        $objetivos = Objetivo::where('id_colaborador', $colab->id)->paginate();
        $objetivoNewForm = new Objetivo();
        $totalPorcentaje = $objetivos->sum('porcentaje');
        $totalNota = $objetivos->sum('nota_super');

        return view('objetivo.index', compact('objetivos', 'objetivoNewForm', 'totalPorcentaje', 'totalNota'))
            ->with('i', (request()->input('page', 1) - 1) * $objetivos->perPage());
    }


    public function indexCalificar(Request $request)
    {

        // NULLS VARIABLES
        $id_area = request('id_area');
        $id_departamento = request('id_departamento');
        $id_cargo = request('id_cargo');
        $id_puesto = request('id_puesto');

        $cargos = null;
        $puestos = null;
        $departamentos = null;
        $colaboradores = null;


        // areas
        $areas = Area::all();
        // if (!$areas->isEmpty() && !$id_area) $id_area = $areas[0]->id;


        // Departamentos
        if ($id_area) $departamentos = Departamento::where('id_area', $id_area)->get();
        else $departamentos = Departamento::all();


        // Cargos
        $cargos = Cargo::all();

        // Puestos
        if ($id_cargo) $puestos = Puesto::where('id_cargo', $id_cargo)->get();
        else $puestos = Puesto::all();


        // COLABORADORES
        $user = auth()->user();
        if (!$user) {
            abort(404);
        }

        // obtenemos el colaborador por id de usuario
        $colaborador = Colaboradore::where([
            'id_usuario' => $user->id,
        ])->first();


        $colaboradores_a_supervisar = Supervisore
            ::join('colaboradores as C', 'supervisores.id_colaborador', '=', 'C.id')
            ->join('puestos as P', 'C.id_puesto', '=', 'P.id')
            ->where('supervisores.id_supervisor', $colaborador->id)
            ->when($id_cargo !== null, function ($query) use ($id_cargo) {
                return $query->where('C.id_cargo', $id_cargo);
            })
            ->when($id_puesto !== null, function ($query) use ($id_puesto) {
                return $query->where('C.id_puesto', $id_puesto);
            })
            ->get();
        return view('objetivo.calificar', compact('areas', 'departamentos', 'cargos', 'puestos', 'id_area', 'id_departamento', 'id_cargo', 'id_puesto', 'colaboradores_a_supervisar'));
    }

    // public function indexCalificar(Request $request)
    // {
    //     $idColaborador = request('id_colaborador');
    //     $areas = Area::all();


    //     $user = auth()->user();
    //     if (!$user) {
    //         abort(404);
    //     }
    //     $id = $user->id;

    //     // obtenemos el colaborador por id de usuario
    //     $colaborador = Colaboradore::where([
    //         'id_usuario' => $id,
    //     ])->first();

    //     // obtenemos el supervisor del colaborador
    //     // $colab_a_supervisar = Supervisore::where('id_supervisor', $colab->id);
    //     $colab_a_supervisar = Supervisore::where('id_supervisor', $colaborador->id)->paginate();

    //     $objetivos = null;

    //     if ($idColaborador) {
    //         $objetivos = Objetivo::where('id_supervisor', $colaborador->id)->where('id_colaborador', $idColaborador)->paginate();
    //     } else {
    //         $objetivos = Objetivo::where('id_supervisor', $colaborador->id)->paginate();
    //     }

    //     $objetivoNewForm = new Objetivo();
    //     $totalPorcentaje = $objetivos->sum('porcentaje');
    //     $totalNota = $objetivos->sum('nota_super');

    //     $objetivosDesaprobados = $objetivos->filter(function ($objetivo) {
    //         return $objetivo->estado === 0 && !empty($objetivo->feedback);
    //     });

    //     view()->share([
    //         'objetivosdesaprobados' => $objetivosDesaprobados,
    //     ]);

    //     return view('objetivo.calificar', compact('objetivos', 'objetivoNewForm', 'totalPorcentaje', 'totalNota', 'colab_a_supervisar', 'idColaborador', 'colaborador', 'areas'))
    //         ->with('i', (request()->input('page', 1) - 1) * $objetivos->perPage());
    // }


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

        $user = auth()->user();
        if (!$user) {
            abort(404);
        }
        $id = $user->id;

        // obtenemos el colaborador por id de usuario
        $colab = Colaboradore::where([
            'id_usuario' => $id,
        ])->first();

        // Valida los datos del formulario
        $validatedData = $request->validate(Objetivo::$rules);

        $objetivos = Objetivo::where('id_colaborador', $colab->id)->paginate();
        $totalPorcentaje = $objetivos->sum('porcentaje');


        if (($totalPorcentaje + $validatedData['porcentaje']) > 100) {
            return back()->withErrors(['porcentaje' => 'La suma total de porcentaje excede 100'])->withInput();
        }

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
            'id_supervisor' => $super->id_supervisor,
            'estado' => 1,
            'eva' => 1,
            'año' => '2023',
            'notify_super' => 1,
            'notify_colab' => 0,
            'porcentaje' =>  $request->input('porcentaje'),
            'porcentaje_inicial' => $request->input('porcentaje')
        ]);

        // Crea un nuevo Objetivo con los datos combinados
        Objetivo::create($data);

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


    public function desaprobar(Request $request)
    {
        $request->validate([
            'feedback' => 'string|max:255',
            'id' => 'required|integer|min:1',

        ]);

        $objetivo = Objetivo::find($request->id);

        if (!$objetivo) {
            return redirect()->route('objetivo.calificarindex')->with('error', 'El objetivo no existe.');
        }

        $objetivo->feedback = $request->feedback;
        $objetivo->feedback_fecha = Carbon::now();
        $objetivo->notify_super = 0;
        $objetivo->notify_colab = 1;
        $objetivo->estado = 0;

        $objetivo->save();

        return redirect()->route('objetivo.calificarindex')
            ->with('success', 'Objetivo actualizado correctamente.');
    }
}
