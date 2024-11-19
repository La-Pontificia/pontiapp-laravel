<?php

namespace App\Http\Controllers;

use App\Jobs\AssistsSnSchedules;
use App\Jobs\AssistsWithoutCalculating;
use App\Models\Area;
use App\Models\AssistTerminal;
use App\Models\Department;
use App\services\AssistsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssistsController extends Controller
{
    protected $assistsService;

    public function __construct(AssistsService $assistsService)
    {
        $this->assistsService = $assistsService;
    }

    // CENTRALIZED
    public function index(Request $req)
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '2G');
        $terminalsIds = $req->get('assist_terminals') ? explode(',', $req->get('assist_terminals')) : [];
        $query = $req->get('query');
        $startDate = $req->get('start');
        $endDate = $req->get('end');

        $area_id = $req->get('area');
        $department_id = $req->get('department');

        $areas = Area::all();
        $departments = Department::all();
        $terminals = AssistTerminal::all();

        if ($area_id) {
            $departments = Department::where('id_area', $area_id)->get();
        }

        $build =  $this->assistsService->centralized($query, $terminalsIds, $startDate, $endDate, $area_id, $department_id);

        return view('modules.assists.+page', [
            'areas' => $areas,
            'departments' => $departments,
            'assists' => $build['assists'],
            'totalAssists' => $build['total'],
            'totalUsers' => $build['totalUsers'],
            'totalUserShown' => $build['usersShown'],
            'terminals' => $terminals,
        ]);
    }

    public function centralizedReport(Request $req)
    {
        return response()->json('El reporte de asistencias centralizada aun no esta disponible');
    }

    // CENTRALIZED WITHOUT CALCULATING
    public function centralizedWithoutCalculating(Request $req)
    {

        $area_id = $req->get('area');
        $department_id = $req->get('department');
        $terminalsIds = $req->get('assist_terminals') ? explode(',', $req->get('assist_terminals')) : [];

        $startDate = $req->get('start');
        $endDate = $req->get('end');
        $query = $req->get('query');

        $terminals = AssistTerminal::all();
        $areas = Area::all();
        $departments = Department::all();

        if ($area_id) {
            $departments = Department::where('id_area', $area_id)->get();
        }

        $built = $this->assistsService->centralizedWithoutCalculating($query, $terminalsIds, $startDate, $endDate, $area_id, $department_id);
        return view(
            'modules.assists.centralized-without-calculating.+page',
            [
                'terminals' => $terminals,
                'assists' => $built['assists'],
                'total' => $built['total'],
                'departments' => $departments,
                'areas' => $areas,
            ]
        );
    }

    public function centralizedWithoutCalculatingReport(Request $req)
    {

        $terminalsIds = $req->get('assist_terminals') ? explode(',', $req->get('assist_terminals')) : [];
        $startDate = $req->get('start');
        $endDate = $req->get('end');
        $query = $req->get('query');

        if (!$startDate || !$endDate) {
            return response()->json('Debe seleccionar una fecha de inicio y una fecha de fin');
        }

        if (count($terminalsIds) == 0) {
            return response()->json('Debe seleccionar al menos un terminal');
        }

        $user = Auth::user();


        AssistsSnSchedules::dispatch($query, $terminalsIds, $startDate, $endDate, Auth::id());

        return response()->json('Una vez finalizado el proceso se le notificará al correo electrónico: ' . $user->email . ' O tambien ver el archivo en la sección de reportes / descargas');
    }

    // SINGLE
    public function withoutCalculating(Request $req)
    {

        $terminals = AssistTerminal::all();
        $terminalsIds = $req->get('assist_terminals') ? explode(',', $req->get('assist_terminals')) : [];

        $startDate = $req->get('start');
        $endDate = $req->get('end');
        $query = $req->get('query');
        $built = $this->assistsService->withoutCalculating($query, $terminalsIds, $startDate, $endDate);
        $terminals = AssistTerminal::all();
        return view(
            'modules.assists.without-calculating.+page',
            [
                'terminals' => $terminals,
                'assists' => $built['assists'],
                'total' => $built['total'],
            ]
        );
    }

    public function withoutCalculatingReport(Request $req)
    {
        $query = $req->get('query');
        $terminalsIds = $req->get('assist_terminals') ? explode(',', $req->get('assist_terminals')) : [];
        $startDate = $req->get('start');
        $endDate = $req->get('end');

        if (!$startDate || !$endDate) {
            return response()->json('Debe seleccionar una fecha de inicio y una fecha de fin');
        }

        if (count($terminalsIds) == 0) {
            return response()->json('Debe seleccionar al menos un terminal');
        }

        $user = Auth::user();

        AssistsWithoutCalculating::dispatch($query, $terminalsIds, $startDate, $endDate, Auth::id());

        return response()->json('Una vez finalizado el proceso se le notificará al correo electrónico: ' . $user->email . ' O tambien ver el archivo en la sección de reportes / descargas');
    }


    public function singleSummary(Request $req)
    {

        $terminals = AssistTerminal::all();
        $terminal = $req->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $req->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $req->get('end', Carbon::now()->format('Y-m-d'));

        $assists = collect([]);
        if ($startDate && $endDate) {
            $assists = $this->assistsService->singleSummary($terminal, $startDate, $endDate);
        }

        $terminals = AssistTerminal::all();

        return view('modules.assists.single-summary.+page', [
            'assists' => $assists,
            'terminals' => $terminals,
        ]);
    }

    public function checkStatusServer()
    {
        $cacheKey = 'status_server_PL_Alameda';
        $cachedResponse = Cache::get($cacheKey);

        if ($cachedResponse) {
            return response()->json($cachedResponse);
        }

        try {
            $startTime = microtime(true);

            DB::connection('PL-Alameda')->getPdo();

            $executionTime = microtime(true) - $startTime;

            $response = [
                'status' => 'success',
                'message' => 'Servidor activo.',
                'execution_time' => $executionTime . ' seconds',
            ];

            Cache::put($cacheKey, $response, 240);

            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Error al conectar con el servidor.',
                'error' => $e->getMessage(),
            ];

            Cache::put($cacheKey, $response, 240);

            return response()->json($response);
        }
    }
}
