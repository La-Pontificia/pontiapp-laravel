<?php

namespace App\Http\Controllers;

use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\Goal;
use App\Models\JobPosition;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;

class EdaController  extends Controller
{

    public function index(Request $request)
    {
        $cuser = auth()->user();
        $match = User::orderBy('created_at', 'desc');
        $query = $request->get('q');
        $job_position = $request->get('job_position');
        $job_positions = JobPosition::all();
        $role = $request->get('role');
        $users = [];

        if (in_array('edas:view', $cuser->role->privileges) &&  !in_array('edas:view_all', $cuser->role->privileges)) {
            $match->where('supervisor_id', $cuser->id);
        }


        // filters
        if ($job_position) {
            $match->whereHas('role_position', function ($q) use ($job_position) {
                $q->where('id_job_position', $job_position);
            });
        }

        if ($role) {
            $match->where('id_role', $role);
        }

        if ($query) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->get();
        }

        $jobPostions = JobPosition::all();
        $roles = Role::all();

        $users = $match->paginate();

        return view('modules.edas.+page', compact('users', 'job_positions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function me()
    {
        $user = auth()->user();
        $year = Year::orderBy('name', 'desc')->first();
        if (!$year) return view('pages.404');
        return redirect('/edas/' . $user->id . '/eda/' . $year->id);
    }

    public function user($id_user)
    {
        $user = User::find($id_user);
        $year = Year::orderBy('name', 'desc')->first();
        return redirect('edas/' . $user->id . '/eda/' . $year->id);
    }

    public function year($id_user, $id_year)
    {
        $user = User::find($id_user);
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $current_year->id)->first();

        $evaluations = [];

        if ($eda) {
            $evaluations = Evaluation::where('id_eda', $eda->id)->get();
        }

        return view(
            'modules.edas.slug.+page',
            compact('user', 'years', 'current_year', 'eda', 'evaluations')
        );
    }

    public function goals($id_user, $id_year)
    {
        $user = User::find($id_user);
        $years = Year::orderBy('name', 'desc')->get();
        $year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $year->id)->first();


        // validate 
        if (!$eda) return view('pages.500', ['error' => 'Eda not found']);
        if (!$year) return view('pages.500', ['error' => 'Year not found']);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        $goals = [];
        if ($eda) {
            $goals = Goal::where('id_eda', $eda->id)->get();
        }

        $current_year = Year::find($id_year);

        return view(
            'modules.edas.slug.goals.+page',
            compact('user', 'years', 'year', 'eda', 'goals', 'current_year')
        );
    }

    public function evaluation($id_user, $id_year, $id_evaluation)
    {
        $user = User::find($id_user);
        $evaluation = Evaluation::find($id_evaluation);
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $current_year->id)->first();
        $goals = [];

        // validate
        if (!$eda) return view('pages.500', ['error' => 'Eda not found']);
        if (!$current_year) return view('pages.500', ['error' => 'Year not found']);
        if (!$user) return view('pages.500', ['error' => 'User not found']);
        if (!$evaluation) return view('pages.500', ['error' => 'Evaluation not found']);


        if ($eda) {
            $goals = Goal::where('id_eda', $eda->id)->get();
        }

        return view(
            'modules.edas.slug.evaluation.+page',
            compact('user', 'years', 'current_year', 'eda', 'goals', 'evaluation')
        );
    }

    public function questionnaires($id_user, $id_year)
    {
        $user = User::find($id_user);
        $years = Year::orderBy('name', 'desc')->get();
        $year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $year->id)->first();

        // validate
        if (!$eda) return view('pages.500', ['error' => 'Eda not found']);
        if (!$year) return view('pages.500', ['error' => 'Year not found']);
        if (!$user) return view('pages.500', ['error' => 'User not found']);

        return view(
            'modules.edas.slug.questionnaires.+page',
            compact('user', 'years', 'year', 'eda')
        );
    }
}
