<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPositionController extends Controller
{

    // job positions 
    public function index(Request $req)
    {
        $match = JobPosition::orderBy('level', 'asc');
        $query = $req->get('query');
        $level = $req->get('level');

        if ($query) {
            $match->where('name', 'like', '%' . $query . '%')
                ->orWhere('code', 'like', '%' . $query . '%')
                ->get();
        }

        if ($level) {
            $match->where('level', $level);
        }

        $jobs = $match->paginate();
        $lastJob = JobPosition::orderBy('created_at', 'desc')->first();

        $newCode = 'P-001';
        if ($lastJob) {
            $newCode = 'P-' . str_pad((int)explode('-', $lastJob->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }
        return view('modules.settings.job-positions.+page', compact('jobs', 'newCode'))
            ->with('i', (request()->input('page', 1) - 1) * $jobs->perPage());
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'level' => ['required', 'numeric'],
        ]);

        $alreadyExistCode = JobPosition::where('code', $req->code)->first();
        if ($alreadyExistCode) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $last = JobPosition::orderBy('created_at', 'desc')->first();
        $code = 'P-001';
        if ($last) {
            $code = 'P-' . str_pad((int)explode('-', $last->code)[1] + 1, 3, '0', STR_PAD_LEFT);
        }

        $new = new JobPosition();
        $new->code = $code;
        $new->name = $req->name;
        $new->level = $req->level;
        $new->created_by = Auth::id();
        $new->save();

        return response()->json('Puesto de trabajo creado correctamente', 200);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'code' => 'required',
            'level' => ['required', 'numeric'],
        ]);

        $alreadyExistCode = JobPosition::where('code', $req->code)->first();

        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $update = JobPosition::find($id);
        $update->code = $req->code;
        $update->name = $req->name;
        $update->level = $req->level;
        $update->updated_by = Auth::id();
        $update->save();

        return response()->json('Puesto de trabajo actualizado correctamente.', 200);
    }

    public function delete($id)
    {
        $job = JobPosition::find($id);
        $job->delete();
        return response()->json('Registro eliminado correctamente.', 200);
    }
}
