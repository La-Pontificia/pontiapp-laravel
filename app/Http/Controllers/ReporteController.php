<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cargo;
use App\Models\Colaboradore;
use App\Models\Departamento;
use App\Models\Eda;
use App\Models\EdaColab;
use App\Models\Objetivo;
use App\Models\Puesto;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        return redirect()->route('reportes.edas');
    }

    public function objetivos()
    {

        $desde = request()->query('desde');
        $hasta = request()->query('hasta');
        $colaborador_id = request()->query('colaborador');
        $colaborador = null;
        $estado = request()->query('estado');
        $query = Objetivo::orderBy('created_at', 'desc');


        // rango
        if ($desde) {
            $eda = Eda::find($desde);
            $query->whereHas('edaColab', function ($q) use ($eda) {
                $q->whereHas('eda', function ($innerQ) use ($eda) {
                    $innerQ->where('año', '>=', $eda->año);
                });
            });
        }

        if ($hasta) {
            $eda = Eda::find($hasta);
            $query->whereHas('edaColab', function ($q) use ($eda) {
                $q->whereHas('eda', function ($innerQ) use ($eda) {
                    $innerQ->where('año', '<=', $eda->año);
                });
            });
        }

        // estado
        if ($estado == '1') {
            $query->whereHas('edaColab', function ($q) use ($estado) {
                $q->where('enviado', true);
                $q->where('aprobado', false);
            });
        }

        if ($estado == '2') {
            $query->whereHas('edaColab', function ($q) use ($estado) {
                $q->where('aprobado', true);
                $q->where('cerrado', false);
            });
        }

        if ($estado == '3') {
            $query->whereHas('edaColab', function ($q) use ($estado) {
                $q->where('cerrado', true);
            });
        }

        // colaborador
        if ($colaborador_id) {
            $colaborador = Colaboradore::find($colaborador_id);
            $query->whereHas('edaColab', function ($q) use ($colaborador_id) {
                $q->where('id_colaborador', $colaborador_id);
            });
        }




        $objetivos = $query->paginate();
        $edas = Eda::all();

        $objetivos->appends(request()->query());

        return view('reportes.objetivos.index', compact('objetivos', 'edas', 'colaborador'))
            ->with('i', (request()->input('page', 1) - 1) * $objetivos->perPage());
    }

    public function edas()
    {

        $desde = request()->query('desde');
        $hasta = request()->query('hasta');
        $colaborador_id = request()->query('colaborador');
        $colaborador = null;
        $estado = request()->query('estado');
        $query = EdaColab::orderBy('created_at', 'desc');
        $id_cargo = request('cargo');
        $id_puesto = request('puesto');

        if ($id_cargo && !$colaborador_id) {
            $query->whereHas('colaborador', function ($q) use ($id_cargo) {
                $q->where('id_cargo', $id_cargo);
            });
        }

        if ($id_puesto && !$colaborador_id) {
            $query->whereHas('colaborador', function ($q) use ($id_puesto) {
                $q->where('id_puesto', $id_puesto);
            });
        }

        // rango
        if ($desde) {
            $query->whereHas('eda', function ($q) use ($desde) {
                $q->where('año', '>=', $desde);
            });
        }

        if ($hasta) {
            $query->whereHas('eda', function ($q) use ($hasta) {
                $q->where('año', '<=', $hasta);
            });
        }


        // estado
        if ($estado == '1') {
            $query->where('enviado', true);
            $query->where('aprobado', false);
        }

        if ($estado == '2') {
            $query->where('aprobado', true);
            $query->where('cerrado', false);
        }

        if ($estado == '3') {
            $query->where('cerrado', true);
        }

        // colaborador
        if ($colaborador_id) {
            $colaborador = Colaboradore::find($colaborador_id);
            $query->where('id_colaborador', $colaborador_id);
        }


        $edas = $query->paginate();
        $edasList = Eda::all();
        $edas->appends(request()->query());
        $cargos = Cargo::all();
        $puestos = Puesto::all();
        if ($id_cargo) $puestos = Puesto::where('id_cargo', $id_cargo)->get();



        ///// EXPORT JSON
        if (request()->query('export') === 'json') {
            $data = collect();
            $edas->each(function ($edaColab, $index) use ($data) {
                $item = $this->mapEdaColabToItem($edaColab, $index);
                if (request()->query('eva2')) {
                    $item += $this->mapEvaluacion2ToItem($edaColab);
                }
                $data->push($item);
            });

            return response()->json($data);
        }


        ///// REPORT TIME LINE
        if (request()->query('report') === 'timeline') {
            $resultados = [
                'enviados' => $this->procesarFechas($edas, 'fecha_envio'),
                'aprobados' => $this->procesarFechas($edas, 'fecha_aprobado'),
                'cerrados' => $this->procesarFechas($edas, 'fecha_cerrado'),
            ];
            return response()->json($resultados);
        }

        return view('reportes.edas.index', compact(
            'edasList',
            'edas',
            'colaborador',
            'cargos',
            'puestos'
        ))
            ->with('i', (request()
                ->input('page', 1) - 1) * $edas
                ->perPage());
    }

    public function colaboradores()
    {

        $id_area = request('area');
        $id_departamento = request('departamento');
        $id_cargo = request('cargo');
        $id_puesto = request('puesto');
        $search = request('query');
        $estado = request('estado');

        $cargos = Cargo::all();
        $puestos = Puesto::all();
        $sedes = Sede::all();
        $departamentos = Departamento::all();
        $areas = Area::all();

        if ($id_cargo) $puestos = Puesto::where('id_cargo', $id_cargo)->get();
        if ($id_area) $departamentos = Departamento::where('id_area', $id_area)->get();
        if ($id_cargo) {
            if ($id_departamento) {
                $puestos = Puesto::where('id_cargo', $id_cargo)
                    ->where('id_departamento', $id_departamento)
                    ->get();
            }
            $puestos = Puesto::where('id_cargo', $id_cargo)
                ->get();
        }

        /// COLABORADORES
        $query = Colaboradore::orderBy('created_at', 'desc');
        if ($id_cargo) $query->where('id_cargo', $id_cargo);
        if ($id_puesto) $query->where('id_puesto', $id_puesto);
        if ($estado == '1') $query->where('estado', true);
        if ($estado == '2') $query->where('estado', false);


        if ($id_area) {
            $query->whereHas('puesto', function ($q) use ($id_area) {
                $q->whereHas('departamento', function ($q) use ($id_area) {
                    $q->where('id_area', $id_area);
                });
            });
        }


        if ($query) {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('nombres', 'like', "%$search%")
                    ->orWhere('apellidos', 'like', "%$search%")
                    ->orWhere('dni', 'like', "%$search%");
            });
        }

        $colaboradores = $query->paginate();
        $colaboradores->appends(request()->query());

        if (request()->query('export') === 'json') {
            $data = $colaboradores->map(function ($colab, $index) {
                $rol = null;
                if ($colab->rol === 0) {
                    $rol = 'Colaborador';
                }
                if ($colab->rol === 1) {
                    $rol = 'Admin';
                }
                if ($colab->rol === 2) {
                    $rol = 'Dev';
                }
                $item = [
                    'Nro' => $index,
                    'DNI' => $colab->dni,
                    'APELLIDOS Y NOMBRE' => $colab->apellidos . ' ' . $colab->nombres,
                    'CORREO' => $colab->correo_institucional ?? '-',
                    'PERFIL' => $colab->perfil ?? '-',
                    'SUPERVISOR' =>  $colab->id_supervisor ? $colab->supervisor->apellidos . ' ' . $colab->supervisor->nombres : '-',
                    'AREA' => $colab->puesto->departamento->area->nombre_area,
                    'DEPARTAMENTO' => $colab->puesto->departamento->nombre_departamento,
                    'CARGO' => $colab->cargo->nombre_cargo,
                    'PUESTO' => $colab->puesto->nombre_puesto,
                    'SEDE' => $colab->sede->nombre,
                    'ESTADO' => $colab->estado ? 'ACTIVO' : 'INACTIVO',
                    'ROL' => $rol,
                    'FECHA CREACION' => $colab->created_at,
                    'FECHA MODIFICACION' => $colab->updated_at,
                ];
                return $item;
            });
            return response()->json($data);
        }

        if (request()->query('report') === 'timeline') {
            $colaboradores = $query->get();
            $colaboradoresTimeline = $colaboradores->groupBy(function ($colaborador) {
                return $colaborador->created_at->format('Y-m-d');
            })->map(function ($group) {
                return [
                    'time' => $group->first()->created_at->format('Y-m-d'),
                    'value' => $group->count(),
                ];
            })->values();

            return response()->json($colaboradoresTimeline);
        }

        return view('reportes.colaboradores.index', compact(
            'cargos',
            'puestos',
            'sedes',
            'departamentos',
            'areas',
            'colaboradores'
        ))
            ->with('i', (request()
                ->input('page', 1) - 1) * $colaboradores
                ->perPage());
    }

    /////// COMMONS

    private function mapEdaColabToItem($edaColab, $index)
    {
        return [
            'Nro' => $index,
            'EDA' => $edaColab->eda->año,
            'APELLIDOS Y NOMBRE' => $edaColab->colaborador->nombres . ' ' . $edaColab->colaborador->apellidos,
            'DNI' => $edaColab->colaborador->dni,
            'CORREO' => $edaColab->colaborador->correo_institucional ?: '-',
            'CARG0' => $edaColab->colaborador->cargo->nombre_cargo,
            'PUESTO' => $edaColab->colaborador->puesto->nombre_puesto,
            'APROBADO' => $edaColab->aprobado ? 'S' : 'N',
            'FECHA APROBADO' => $edaColab->aprobado ? $edaColab->fecha_aprobado : '-',
            'CERRADO' => $edaColab->cerrado ? 'S' : 'N',
            'FECHA CERRADO' => $edaColab->cerrado ? $edaColab->fecha_cerrado : '-',
            'EVA1 NA' => $edaColab->evaluacion->autocalificacion,
            'EVA1 PRO' => $edaColab->evaluacion->promedio,
            'EVA1 CERRADO' => $edaColab->evaluacion->cerrado ? 'S' : 'N',
            'EVA1 FECHA CERRADO' => $edaColab->evaluacion->fecha_cerrado ?: '-',
            'EVA1 FEEDBACK' => 'N',
        ];
    }

    private function mapEvaluacion2ToItem($edaColab)
    {
        return [
            'EVA2 NA' => $edaColab->evaluacion2->autocalificacion,
            'EVA2 PRO' => $edaColab->evaluacion2->promedio,
            'EVA2 CERRADO' => $edaColab->evaluacion2->cerrado ? 'S' : 'N',
            'EVA2 FECHA CERRADO' => $edaColab->evaluacion2->fecha_cerrado ?: '-',
            'EVA2 FEEDBACK' => 'N',
        ];
    }

    private function procesarFechas($edas, $fechaCampo)
    {
        $edasConFecha = $edas->filter(function ($eda) use ($fechaCampo) {
            return $eda->$fechaCampo !== null && strtotime($eda->$fechaCampo) !== false;
        });

        return $edasConFecha->groupBy(function ($colaborador) use ($fechaCampo) {
            return Carbon::parse($colaborador->$fechaCampo)->format('Y-m-d');
        })->map(function ($group) {
            return [
                'time' => Carbon::parse($group->first()->fecha_envio)->format('Y-m-d'),
                'value' => $group->count(),
            ];
        })->values();
    }
}
