<?php

namespace App\Http\Controllers;


use App\Models\Area;
use App\Models\Auditoria;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Puesto;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class ColaboradoreController
 * @package App\Http\Controllers
 */
class ColaboradoreController extends GlobalController
{

    public function index()
    {


        $colab = $this->getCurrentColab();
        $accesoModulo = true;
        // NULLS VARIABLES
        $id_cargo = request('cargo');
        $id_puesto = request('puesto');
        $search = request('q');


        $cargos = Cargo::all();
        $puestos = Puesto::all();
        $colaboradores = null;

        $allowLists = $colab->rol != 0;

        // Cargos
        if ($id_puesto)
            $cargos = Cargo::where('id_puesto', $id_puesto)->get();
        $colaboradorForm = new Colaboradore();

        $colaboradores = null;
        $query = Colaboradore::orderBy('created_at', 'asc');

        if ($id_cargo) {
            $query->where('colaboradores.id_cargo', $id_cargo);
        }

        if ($id_puesto) {
            $query->whereHas('cargo', function ($q) use ($id_puesto) {
                $q->where('id_puesto', $id_puesto);
            });
        }


        if ($search) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('nombres', 'like', "%$search%")
                    ->orWhere('apellidos', 'like', "%$search%")
                    ->orWhere('dni', 'like', "%$search%");
            });
        }

        if (!$allowLists) {
            $query->where('colaboradores.id_supervisor', $colab->id);
        }

        $colaboradores = $query->paginate();

        // SEDES
        $sedes = Sede::all();
        return view('colaboradore.index', compact('colaboradores', 'colaboradorForm', 'puestos', 'cargos', 'sedes'))
            ->with('i', (request()->input('page', 1) - 1) * $colaboradores->perPage());
    }

    public function cambiarPerfil(Request $request)
    {
        $id = $request->id;
        $colaborador = Colaboradore::find($id);
        $colaborador->perfil = $request->url;
        $colaborador->save();
        return response()->json(['success' => 'Perfil catualizado correctamente.'], 202);
    }

    public function cambiarEstado($id)
    {
        $colaborador = Colaboradore::find($id);
        $colaborador->estado = !$colaborador->estado;
        $colaborador->save();
        return response()->json(['success' => 'Estado catualizado correctamente.'], 202);
    }

    public function cambiarClave(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:5',
        ]);
        $user = User::where('id_colaborador', $id)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['success' => 'Clave actualizada correctamente.'], 200);
    }

    public function store(Request $request)
    {
        request()->validate(Colaboradore::$rules);
        $colab = $this->getCurrentColab();
        $validateUser = User::where('email', $request->input('dni'))->first();
        if ($validateUser)
            return response()->json(['error' => 'El usuario con el DNI ingresado ya existe'], 400);

        $rol = $request->input('rol');
        $privilegios = [];

        if ($rol == 0) {
            $privilegios = ["ver_colaboradores", "mis_edas", "mis_objetivos", "enviar_objetivos", "enviar_cuestionario", "1ra_evaluacion", "2da_evaluacion", "ver_edas", "crear_eda", "cerrar_eda", "autocalificar", "calificar", "cerrar_eva"];
        }

        if ($rol == 1) {
            $privilegios = ["mantenimiento", "reportes", "contraseña_colaborador", "crear_colaborador", "editar_colaborador", "asignar_supervisor", "enviar_objetivos", "autocalificar", "calificar", "cerrar_eva", "cerrar_eda", "enviar_cuestionario", "ver_colaboradores", "ver_edas", "crear_eda"];
        }

        if ($rol == 2) {
            $privilegios = ["mantenimiento", "reportes", "contraseña_colaborador", "crear_colaborador", "editar_colaborador", "accesos_colaborador", "estado_colaborador", "asignar_supervisor", "enviar_objetivos", "autocalificar", "calificar", "cerrar_eva", "cerrar_eda", "enviar_cuestionario", "ver_colaboradores", "ver_edas", "auditoria", "crear_eda"];
        }


        $colaborador = Colaboradore::create([
            'dni' => $request->input('dni'),
            'apellidos' => $request->input('apellidos'),
            'nombres' => $request->input('nombres'),
            'correo_institucional' => $request->input('correo_institucional'),
            'id_sede' => $request->input('id_sede'),
            'id_cargo' => $request->input('id_cargo'),
            'privilegios' => $privilegios,
            'rol' => $rol
        ]);


        User::create([
            'name' => $request->input('nombres'),
            'email' => $request->input('dni'),
            'id_colaborador' => $colaborador->id,
            'password' => bcrypt($request->input('dni')),
        ]);


        Auditoria::create([
            'id_colab' => $colab->id,
            'modulo' => 'Colaborador',
            'titulo' => 'Nuevo colaborador',
            'descripcion' => 'Se creo un nuevo colaborador con el DNI: ' . $colaborador->dni,
        ]);

        return redirect()->route('colaboradores.index')
            ->with('success', 'Colaboradore created successfully.');
    }


    public function updateSupervisor()
    {
        $colab = $this->getCurrentColab();
        $id_colab = request('id_colab');
        $id_super = request('id_super');
        $Colab = Colaboradore::find($id_colab);
        $Colab->id_supervisor = $id_super;
        $Colab->save();

        Auditoria::create([
            'id_colab' => $colab->id,
            'modulo' => 'Colaborador',
            'titulo' => 'Supervisor agregado',
            'descripcion' => 'Se le asignó un nuevo supervisor al colaborador con el DNI: ' . $Colab->dni,
        ]);

        return response()->json(['success' => 'Colaborador actualizado correctamente.'], 202);
    }

    public function update(Request $request, $id)
    {
        $colaboradore = Colaboradore::find($id);
        $colaboradore->update([
            'dni' => $request->input('dni'),
            'apellidos' => $request->input('apellidos'),
            'nombres' => $request->input('nombres'),
            'correo_institucional' => $request->input('correo_institucional'),
            'id_sede' => $request->input('id_sede'),
            'id_puesto' => $request->input('id_puesto'),
            'rol' => $request->input('rol'),
        ]);

        return redirect()->route('colaboradores.index');
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

    public function privilegios($id)
    {
        $colaborador = Colaboradore::find($id);
        $privilegios = $colaborador->privilegios;
        return response()->json($privilegios);
    }

    public function actualizarPrivilegios(Request $request)
    {
        $id = $request->id;
        $privilegios = $request->list;
        $colaborador = Colaboradore::find($id);
        $colaborador->privilegios = $privilegios;
        $colaborador->save();
        return response()->json(['success' => 'Privilegios actualizados correctamente.'], 202);
    }
}
