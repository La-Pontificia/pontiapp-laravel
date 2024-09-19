<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AssistTerminal;
use App\Models\Department;
use App\Models\GroupSchedule;
use App\Models\User;
use App\services\AssistsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AssistsController extends Controller
{
    protected $assistsService;

    public $timeout = 1200;

    public function __construct(AssistsService $assistsService)
    {
        $this->assistsService = $assistsService;
    }

    public function index(Request $request, $isExport = false)
    {

        $terminals = AssistTerminal::all();

        $terminalsIds = $request->get('assist_terminals') ? explode(',', $request->get('assist_terminals')) : [];

        $query = $request->get('query');

        $force_calculation = $request->get('force_calculation');

        // current date
        $startDate = $request->get('start', Carbon::now()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));

        $match = User::orderBy('created_at', 'desc');

        $area_id = $request->get('area');
        $department_id = $request->get('department');

        if ($area_id) {
            $match->whereHas('role_position', function ($q) use ($area_id) {
                $q->whereHas('department', function ($qq) use ($area_id) {
                    $qq->where('id_area', $area_id);
                });
            });
        }

        if ($department_id) {
            $match->whereHas('role_position', function ($q) use ($department_id) {
                $q->where('id_department', $department_id);
            });
        }

        if ($query) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->get();
        }

        if (count($terminalsIds) > 0) {
            $match->whereHas('assistTerminals', function ($q) use ($terminalsIds) {
                $q->whereIn('assist_terminal_id', $terminalsIds);
            });
        }

        $users = [];

        if (count($terminalsIds) < 1) {
            $users = $match->limit(2)->get();
        } else {
            $users = $match->get();
        }

        $areas = Area::all();
        $departments = Department::all();
        $terminals = AssistTerminal::all();

        if ($area_id) {
            $departments = Department::where('id_area', $area_id)->get();
        }

        $allAssists = collect([]);

        foreach ($users as $user) {
            $allAssists =  $allAssists->concat($this->assistsService->assistsByUser($user, $terminalsIds, $startDate, $endDate, $force_calculation));
        }


        if ($isExport) {
            return $allAssists;
        }

        $perPage = 25;
        $currentPage = $request->get('page', 1);

        $assists = $allAssists->forPage($currentPage, $perPage);

        $paginatedAssists = new LengthAwarePaginator(
            $assists,
            isset($allAssists) ? $allAssists->count() : 0,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('modules.assists.+page', [
            'areas' => $areas,
            'departments' => $departments,
            'users' => $users,
            'assists' => $paginatedAssists,
            'terminals' => $terminals,
        ]);
    }

    public function snSchedules(Request $request, $isExport = false)
    {

        $terminals = AssistTerminal::all();
        $terminalsIds = $request->get('assist_terminals') ? explode(',', $request->get('assist_terminals')) : [];

        $startDate = $request->get('start', Carbon::now()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));
        $query = $request->get('query');

        $assists = Collect([]);
        $perPage = 25;
        $currentPage = $request->get('page', 1);

        $allAssists = $this->assistsService->assists($query, $terminalsIds, $startDate, $endDate, $isExport);
        $assists = $allAssists->forPage($currentPage, $perPage);

        $terminals = AssistTerminal::all();

        if ($isExport) {
            return $allAssists;
        }

        $paginatedAssists = new LengthAwarePaginator(
            $assists,
            isset($allAssists) ? $allAssists->count() : 0,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view(
            'modules.assists.sn-schedules.+page',
            [
                'terminals' => $terminals,
                'assists' => $paginatedAssists
            ]
        );
    }

    public function snSchedulesExport(Request $request)
    {
        $assists = $this->snSchedules($request, true);

        foreach ($assists as $assist) {
            $assist['user'] = [
                'first_name' => $assist['user']['first_name'],
                'last_name' => $assist['user']['last_name'],
                'dni' => $assist['user']['dni'],
                'job' => $assist['user']->role_position->job_position->name,
                'role' => $assist['user']->role_position->name,
            ];
        }
        return $assists;
    }

    public function peerSchedule(Request $request, $isExport = false)
    {
        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('d/m/Y'));
        $endDate = $request->get('end', Carbon::now()->format('d/m/Y'));
        $query = $request->get('query');
        $group = $request->get('group');

        $users = [];

        if ($query) {
            $users = $this->assistsService->employee($query, $terminal);
        }

        $allSchedules = collect([]);

        $perPage = 25;
        $currentPage = $request->get('page', 1);

        if ($group) {
            foreach ($users as $user) {
                $allSchedules = $allSchedules->concat($this->assistsService->assistsByEmployee($user, $group, $terminal, $startDate, $endDate));
            }
        }
        $groups = GroupSchedule::all();
        $terminals = AssistTerminal::all();

        $schedules = $allSchedules->forPage($currentPage, $perPage);

        $paginatedSchedules = new LengthAwarePaginator(
            $schedules,
            isset($allSchedules) ? $allSchedules->count() : 0,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        if ($isExport) {
            return $allSchedules;
        }

        return view(
            'modules.assists.peer-schedule.+page',
            [
                'terminals' => $terminals,
                'schedules' => $paginatedSchedules,
                'groups' => $groups,
                'users' => $users,
            ]
        );
    }

    public function peerScheduleExport(Request $request)
    {
        return $this->peerSchedule($request, true);
    }

    public function centralizedExport(Request $request)
    {
        $assists = $this->index($request, true);
        foreach ($assists as $assist) {
            $assist['date'] = Carbon::parse($assist['date'])->format('d/m/Y');
        }

        return $assists;
    }

    public function peerUserExport(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);
        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('d/m/Y'));
        $endDate = $request->get('end', Carbon::now()->format('d/m/Y'));

        $schedules = $this->assistsService->assistsByUser($user->id, $terminal, $startDate, $endDate, false);

        return $schedules;
    }

    public function singleSummary(Request $request)
    {

        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('d-m-Y'));
        $endDate = $request->get('end', Carbon::now()->format('d-m-Y'));

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
