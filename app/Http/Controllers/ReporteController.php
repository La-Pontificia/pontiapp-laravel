<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\Eda;
use App\Models\Objetivo;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
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
}
