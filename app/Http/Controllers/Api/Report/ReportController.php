<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

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
        $reports = $match->get();
        return response()->json($reports);
    }
}
