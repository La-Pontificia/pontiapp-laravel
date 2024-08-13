<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{

    // job positions 
    public function index(Request $request)
    {
        $match = JobPosition::orderBy('level', 'asc');
        $q = $request->get('q');
        $level = $request->get('level');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%')
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level' => ['required', 'numeric'],
        ]);

        $alreadyExistCode = JobPosition::where('code', $request->code)->first();
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
        $new->name = $request->name;
        $new->level = $request->level;
        $new->created_by = auth()->user()->id;
        $new->save();

        return response()->json($new, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'level' => ['required', 'numeric'],
        ]);

        $alreadyExistCode = JobPosition::where('code', $request->code)->first();

        if ($alreadyExistCode && $alreadyExistCode->id != $id) {
            return response()->json('Ya existe un registro con el mismo código.', 500);
        }

        $update = JobPosition::find($id);
        $update->code = $request->code;
        $update->name = $request->name;
        $update->level = $request->level;
        $update->updated_by = auth()->user()->id;
        $update->save();

        return response()->json($update, 200);
    }

    public function delete($id)
    {
        $job = JobPosition::find($id);
        $job->delete();
        return response()->json('Registro eliminado correctamente.', 200);
    }
}
