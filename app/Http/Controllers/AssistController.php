<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AssistController extends Controller
{
    public function index()
    {

        $connections = [
            // 'pl-alameda',
            // 'pl-andahuaylas',
            // 'pl-casuarina',
            // 'pl-cybernet',
            // 'pl-jazmines',
            // 'rh-alameda',
            // 'rh-andahuaylas',
            // 'rh-casuarina',
            // 'rh-jazmines',
        ];

        $allAssists = collect();

        foreach ($connections as $connection) {
            $assists = (new Attendance())
                ->setConnection($connection)
                ->orderBy('punch_time', 'desc')
                ->where('emp_code', '48182459')
                ->get();
            $allAssists = $allAssists->merge($assists);
        }

        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $allAssists->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $assists = new LengthAwarePaginator($currentPageItems, $allAssists->count(), $perPage);
        $assists->setPath(request()->url());

        return view('modules.assists.+page', compact('assists'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function user($id_user)
    {
        $user = User::find($id_user);

        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $assists = [];
        // Attendance::where('emp_code', $user->dni)->orderBy('punch_time', 'desc')->paginate();

        return view('pages.assists.user.schedules', compact('user', 'assists'));
        // ->with('i', (request()->input('page', 1) - 1) * $assists->perPage());
    }
}
