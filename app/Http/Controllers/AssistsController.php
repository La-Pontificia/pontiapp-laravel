<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AssistTerminal;
use App\Models\Department;
use App\Models\User;
use App\services\AssistsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssistsController extends Controller
{
    protected $assistsService;

    public function __construct(AssistsService $assistsService)
    {
        $this->assistsService = $assistsService;
    }

    public function index(Request $request)
    {

        $queryTerminals = $request->get('terminals') ? explode(',', $request->get('terminals')) : null;
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

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


        $areas = Area::all();
        $departments = Department::all();

        if ($area_id) {
            $departments = Department::where('id_area', $area_id)->get();
        }

        $users = [];

        if ($department_id || $area_id) {

            $users =  $match->get();
        }

        $schedules = [];

        foreach ($users as $user) {
            $schedules = array_merge($schedules, $this->assistsService->assistsByUser($user->id, $queryTerminals, $startDate, $endDate));
        }

        $terminals = AssistTerminal::all();

        return view('modules.assists.+page', [
            'areas' => $areas,
            'departments' => $departments,
            'users' => $users,
            'schedules' => $schedules,
            'terminals' => $terminals,
        ]);
    }
}
