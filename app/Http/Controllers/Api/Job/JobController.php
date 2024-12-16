<?php

namespace App\Http\Controllers\Api\Job;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function all(Request $req)
    {
        $match = Job::orderBy('level', 'asc');
        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));
        if ($q) $match->where('name', 'like', "%$q%");
        if (in_array('roles', $relationship)) $match->with('roles');
        $departments = $match->get();
        return response()->json($departments);
    }

    public function create(Request $req)
    {
        $req->validate([
            'codePrefix' => 'required|string',
            'level' => 'required|numeric',
            'name' => 'required|string',
        ]);

        $job = new Job();
        $job->codePrefix = $req->codePrefix;
        $job->level = $req->level;
        $job->name = $req->name;
        $job->save();
        return response()->json($job);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'codePrefix' => 'required|string',
            'level' => 'required|numeric',
            'name' => 'required|string',
        ]);

        $job = Job::find($id);
        $job->codePrefix = $req->codePrefix;
        $job->level = $req->level;
        $job->name = $req->name;
        $job->save();
        return response()->json($job);
    }

    public function delete($id)
    {
        $job = Job::find($id);

        if ($job->roles()->count() > 0) {
            return response()->json('Hay cargos asociados a este puesto, por favor transfiera y vuelve a internarlo.', 400);
        }

        $job->delete();
        return response()->json($job);
    }
}
