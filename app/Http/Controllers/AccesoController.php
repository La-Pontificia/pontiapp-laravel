<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use App\Models\Colaboradore;
use Illuminate\Http\Request;

/**
 * Class AccesoController
 * @package App\Http\Controllers
 */
class AccesoController extends Controller
{

    public function index($id)
    {
        $colaborador = Colaboradore::find($id);
        $acceso_colaborador = $this->getColaboradores($id);
        $acceso_area = $this->getAreas($id);
        $acceso_eda = $this->getEdas($id);
        $acceso_departamento = $this->getDepartamentos($id);
        $acceso_acceso = $this->getAccesos($id);
        $acceso_cargo = $this->getCargos($id);
        $acceso_sede = $this->getSedes($id);
        $acceso_objetivo = $this->getObjetivos($id);
        $acceso_reporte = $this->getReportes($id);
        $acceso_puesto = $this->getPuestos($id);

        return view('acceso.index', compact(
            'colaborador',
            'acceso_colaborador',
            'acceso_area',
            'acceso_eda',
            'acceso_departamento',
            'acceso_acceso',
            'acceso_cargo',
            'acceso_sede',
            'acceso_puesto',
            'acceso_objetivo',
            'acceso_reporte'
        ));
    }


    public function cambiar(Request $request, $id)
    {
        try {
            $name = $request->name;
            $value = $request->value;
            $acceso = Acceso::find($id);
            $acceso->$name = $value;
            $acceso->save();
            return response()->json(['success' => 'true'], 202);
        } catch (\Exception $e) {
            return response()->json(['success' => 'false'], 401);
        }
    }


    function getPuestos($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'puestos')
            ->first();
    }
    function getColaboradores($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'colaboradores')
            ->first();
    }
    function getAreas($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'areas')
            ->first();
    }
    function getEdas($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'edas')
            ->first();
    }
    function getDepartamentos($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'departamentos')
            ->first();
    }
    function getAccesos($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'accesos')
            ->first();
    }
    function getCargos($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'cargos')
            ->first();
    }
    function getSedes($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'sedes')
            ->first();
    }
    function getObjetivos($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'objetivos')
            ->first();
    }
    function getReportes($id)
    {
        return Acceso::where('id_colaborador', $id)
            ->where('modulo', 'reportes')
            ->first();
    }
}
