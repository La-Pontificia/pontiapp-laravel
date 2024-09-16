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
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $query = $request->get('query');

        // current date
        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
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

        $users = [];

        if (!$department_id || !$area_id || !$query) {
            $users =  $match->limit(2)->get();
        } else {
            $users =  $match->get();
        }

        $areas = Area::all();
        $departments = Department::all();
        $terminals = AssistTerminal::all();

        if ($area_id) {
            $departments = Department::where('id_area', $area_id)->get();
        }

        $allSchedules = collect([]);

        foreach ($users as $user) {
            $allSchedules =  $allSchedules->concat($this->assistsService->assistsByUser($user->id, $terminal, $startDate, $endDate));
        }

        if ($isExport) {
            return $allSchedules;
        }

        $perPage = 25;
        $currentPage = $request->get('page', 1);

        $schedules = $allSchedules->forPage($currentPage, $perPage);

        $paginatedSchedules = new LengthAwarePaginator(
            $schedules,
            isset($allSchedules) ? $allSchedules->count() : 0,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('modules.assists.+page', [
            'areas' => $areas,
            'departments' => $departments,
            'users' => $users,
            'schedules' => $paginatedSchedules,
            'terminals' => $terminals,
        ]);
    }

    public function snSchedules(Request $request, $isExport = false)
    {

        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));
        $query = $request->get('query');

        $assists = Collect([]);
        $perPage = 25;
        $currentPage = $request->get('page', 1);

        $allAssists = $this->assistsService->assists($query, $terminal, $startDate, $endDate, $isExport);
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
        $all = $this->snSchedules($request, true);

        foreach ($all as $assist) {
            $assist->date = $assist->punch_time->format('Y-m-d');
            $assist->day = $assist->punch_time->isoFormat('dddd');
        }
        return $all;
    }

    public function peerSchedule(Request $request, $isExport = false)
    {
        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));
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
        return $this->index($request, true);
    }

    public function peerUserExport(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return view('+500', ['error' => 'User not found']);
        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));

        $schedules = $this->assistsService->assistsByUser($user->id, $terminal, $startDate, $endDate);

        return $schedules;
    }


    public function singleSummary(Request $request)
    {

        $terminals = AssistTerminal::all();
        $terminal = $request->get('terminal') ?? $terminals[0]->database_name;

        $startDate = $request->get('start', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end', Carbon::now()->format('Y-m-d'));

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
