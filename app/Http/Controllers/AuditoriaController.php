<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Colaboradore;
use Illuminate\Http\Request;

/**
 * Class AuditoraController
 * @package App\Http\Controllers
 */
class AuditoriaController extends Controller
{

    public function index()
    {
        $query = Auditoria::orderBy('created_at', 'desc');
        $colaborador_id = request()->query('colaborador');
        $colaborador = null;

        if ($colaborador_id) {
            $colaborador = Colaboradore::find($colaborador_id);
            $query->where('id_colab', $colaborador_id);
        }

        $auditoria = $query->paginate();

        return view('auditoria.index', compact('auditoria', 'colaborador'))
            ->with('i', (request()->input('page', 1) - 1) * $auditoria->perPage());
    }
}
