<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Area;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Puesto;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ColaboradoreController
 * @package App\Http\Controllers
 */
class ColaboradoreController extends GlobalController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $colab = $this->getCurrentColab();

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
        // if (!$departamentos->isEmpty() && !$id_departamento) $id_departamento = $departamentos[0]->id;


        // Cargos
        $cargos = Cargo::all();
        // if (!$cargos->isEmpty() && !$id_cargo) $id_cargo = $cargos[0]->id;


        // Puestos
        if ($id_cargo) $puestos = Puesto::where('id_cargo', $id_cargo)->get();
        else $puestos = Puesto::all();

        // if (!$puestos->isEmpty() && !$id_puesto) $id_puesto = $puestos[0]->id;



        $colaboradores = Colaboradore
            // ::join('puestos as P', 'colaboradores.id_puesto', '=', 'P.id')
            // // ->where('id_supervisor', $colab->id)
            ::when($id_cargo !== null, function ($query) use ($id_cargo) {
                return $query->where('colaboradores.id_cargo', $id_cargo);
            })
            ->when($id_puesto !== null, function ($query) use ($id_puesto) {
                return $query->where('colaboradores.id_puesto', $id_puesto);
            })
            ->get();

        $colaboradorForm = new Colaboradore();
        // $colaboradores = Colaboradore::paginate();


        // SEDES
        $sedes = Sede::all();

        return view('colaboradore.index', compact('colaboradores', 'colaboradorForm', 'puestos', 'cargos', 'areas', 'departamentos', 'id_area', 'id_departamento', 'sedes', 'id_cargo', 'id_puesto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colaboradore = new Colaboradore();
        $puestos = Puesto::pluck('nombre_puesto', 'id');
        $cargos = Cargo::pluck('nombre_cargo', 'id');


        return view('colaboradore.create', compact('colaboradore', 'puestos', 'cargos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Colaboradore::$rules);

        $validateUser = User::where('email', $request->input('dni'))->first();
        if ($validateUser) {
            return response()->json(['error' => 'El usuario con el DNI ingresado ya existe'], 400);
        }


        // Crear el usuario en la tabla users
        $user = User::create([
            'name' => $request->input('nombres'),
            'email' => $request->input('dni'),
            'password' => bcrypt($request->input('dni')), // Recuerda cifrar la contraseña
            // Otras columnas del usuario si es necesario
        ]);


        $colaborador = Colaboradore::create([
            'dni' => $request->input('dni'),
            'apellidos' => $request->input('apellidos'),
            'nombres' => $request->input('nombres'),
            'id_cargo' => $request->input('id_cargo'),
            'id_sede' => $request->input('id_sede'),
            'id_puesto' => $request->input('id_puesto'),
            'id_usuario' => $user->id, // Asignar el id del usuario al campo id_usuario
        ]);

        $this->createAccesByColaborador($colaborador->id);
        $this->createEdas($colaborador->id);

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore created successfully.');
    }


    public function updateSupervisor()
    {
        $id_colab = request('id_colab');
        $id_super = request('id_super');
        $Colab = Colaboradore::find($id_colab);
        $Colab->id_supervisor = $id_super;
        $Colab->save();
        return response()->json(['success' => 'Colaborador actualizado correctamente.'], 202);
    }

    public function createAccesByColaborador($id)
    {
        $modulos = ['colaboradores',  'accesos', 'edas', 'areas', 'departamentos', 'cargos', 'puestos', 'sedes', 'reportes', 'objetivos'];
        foreach ($modulos as $modulo) {
            Acceso::create([
                'modulo' => $modulo,
                'crear' => 0,
                'leer' => 0,
                'actualizar' => 0,
                'eliminar' => 0,
                'id_colaborador' => $id
            ]);
        }
    }


    public function createEdas($id_colab)
    {
        $edas = Eda::all();
        foreach ($edas as $eda) {
            EdaColab::create([
                'id_eda' => $eda->id,
                'id_colaborador' => $id_colab,
                'wearing' => $eda->wearing,
                'estado' => 0, // 0 PENDIENTE | 1 ENVIADO | 2 APROBADO | 3 CERRADO
                'cant_obj' => 0,
                'nota_final' => 0,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colaboradore = Colaboradore::find($id);

        return view('colaboradore.show', compact('colaboradore'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colaboradore = Colaboradore::find($id);
        $puestos = Puesto::pluck('nombre_puesto', 'id');
        $cargos = Cargo::pluck('nombre_cargo', 'id');
        return view('colaboradore.edit', compact('colaboradore', 'puestos', 'cargos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Colaboradore $colaboradore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colaboradore $colaboradore)
    {
        request()->validate(Colaboradore::$rules);

        $colaboradore->update($request->all());

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $colaboradore = Colaboradore::find($id)->delete();

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore deleted successfully');
    }

    public function searchColaboradores(Request $request)
    {
        $q = $request->input('q');
        $colaboradores = Colaboradore::where('nombres', 'LIKE', "%$q%")
            ->orWhere('apellidos', 'LIKE', "%$q%")
            ->orWhere('dni', 'LIKE', "%$q%")
            ->take(15)
            ->get();

        return response()->json($colaboradores);
    }
}
