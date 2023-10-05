<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Puesto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ColaboradoreController
 * @package App\Http\Controllers
 */
class ColaboradoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaboradorForm = new Colaboradore();
        $puestos = Puesto::pluck('nombre_puesto', 'id');
        $cargos = Cargo::pluck('nombre_cargo', 'id');

        $colaboradores = Colaboradore::paginate();


        return view('colaboradore.index', compact('colaboradores', 'colaboradorForm', 'puestos', 'cargos'))
            ->with('i', (request()->input('page', 1) - 1) * $colaboradores->perPage());
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
            'id_puesto' => $request->input('id_puesto'),
            'id_usuario' => $user->id, // Asignar el id del usuario al campo id_usuario
        ]);



        $user = Acceso::create([
            'modulo' => 'Colaboradores',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Departamentos',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Areas',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Puestos',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Cargos',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Accesos',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Usuarios',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $user = Acceso::create([
            'modulo' => 'Supervisores',
            'acceso' => 0,
            'id_colaborador' => $colaborador->id,
        ]);

        $this->createEdas($colaborador->id);

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore created successfully.');
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
