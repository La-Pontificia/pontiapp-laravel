<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return redirect('/reports/files');
    }

    public function files(Request $req)
    {

        $query = $req->get('query');

        $cuser = User::find(Auth::id());

        $hasAll = $cuser->has('reports:files:all') || $cuser->isDev();

        $match = Report::orderBy('created_at', 'desc');

        if ($query) {
            $match->where('title', 'like', '%' . $query . '%')->orWhereHas('user', function ($q) use ($query) {
                $q->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('dni', 'like', '%' . $query . '%');
            });
        }

        if (!$hasAll) {
            $match->where('generated_by', $cuser->id);
        }

        $reports = $match->paginate(20);

        return view('modules.reports.files.+page', compact('reports'))
            ->with('i', (request()->input('page', 1) - 1) * $reports->perPage());
    }

    public function update(Request $req, $id)
    {
        $report = Report::find($id);
        $report->title = $req->title;
        $report->save();

        return response()->json('Reporte actualizado');
    }
}
