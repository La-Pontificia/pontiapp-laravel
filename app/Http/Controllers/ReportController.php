<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return redirect('/reports/downloads');
    }

    public function downloads(Request $request)
    {

        $query = $request->get('query');

        $cuser = User::find(auth()->id());

        $hasAll = $cuser->has('reports:downloads:all') || $cuser->isDev();

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

        return view('modules.reports.downloads.+page', compact('reports'))
            ->with('i', (request()->input('page', 1) - 1) * $reports->perPage());
    }

    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        $report->title = $request->title;
        $report->save();

        return response()->json('Reporte actualizado');
    }
}
