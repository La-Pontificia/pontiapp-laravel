<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function all(Request $req)
    {
        $module = $req->query('module');
        $date = $req->query('date');
        $match = Report::orderBy('created_at', 'desc');
        $match->with('user');
        if ($module) {
            $match->where('module', $module);
        }
        if ($date) {
            $match->where('created_at', 'like', "%$date%");
        }

        $authUser = User::find(Auth::id());

        if (!$authUser->hasPrivilege('users:files:all')) {
            $match->where('creatorId', Auth::id());
        }

        $reports = $match->get();
        return response()->json($reports->map(function ($report) {
            return [
                'id' => $report->id,
                'title' => $report->title,
                'downloadLink' => $report->downloadLink,
                'user' => $report->user?->only(['displayName', 'username', 'firstNames', 'lastNames', 'photoURL']),
                'created_at' => $report->created_at,
                'updated_at' => $report->updated_at,
            ];
        }));
    }
}
