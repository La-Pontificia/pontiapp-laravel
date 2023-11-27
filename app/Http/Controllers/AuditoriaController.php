<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;

/**
 * Class AuditoraController
 * @package App\Http\Controllers
 */
class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditoria = Auditoria::orderBy('created_at', 'desc')->paginate();

        return view('auditoria.index', compact('auditoria'))
            ->with('i', (request()->input('page', 1) - 1) * $auditoria->perPage());
    }
}
