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
        $currentUser = auth()->user();
        $match = User::orderBy('created_at', 'asc');
        $query = $request->get('query');
        $job_position = $request->get('job_position');
        $job_positions = JobPosition::all();
        $role = $request->get('role');
        $users = [];

        $seeAllUsers = $currentUser->role === 'admin' || $currentUser->role === 'dev';

        if (!$seeAllUsers) {
            $match->where('id_supervisor', $currentUser->id);
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

        return view('pages.edas.index', compact('users', 'job_positions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function me()
    {
        $user = auth()->user();
        $year = Year::orderBy('name', 'desc')->first();
        return redirect()->route('edas.user.eda', ['id_user' => $user->id, 'year' => $year->id]);
    }

    public function user($id_user)
    {
        $user = User::find($id_user);
        $year = Year::orderBy('name', 'desc')->first();
        return redirect()->route('edas.user.eda', ['id_user' => $user->id, 'year' => $year->id]);
    }

    public function year($id_user, $year)
    {
        $user = User::find($id_user);
        $years = Year::orderBy('name', 'desc')->get();
        $year = Year::find($year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $year->id)->first();

        $evaluations = [];

        if ($eda) {
            $evaluations = Evaluation::where('id_eda', $eda->id)->get();
        }

        return view(
            'pages.edas.user.eda.index',
            compact('user', 'years', 'year', 'eda', 'evaluations')
        );
    }

    public function goals($id_user, $year)
    {
        $user = User::find($id_user);
        $years = Year::orderBy('name', 'desc')->get();
        $year = Year::find($year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $year->id)->first();
        $goals = [];
        if ($eda) {
            $goals = Goal::where('id_eda', $eda->id)->get();
        }

        return view(
            'pages.edas.user.eda.goals.index',
            compact('user', 'years', 'year', 'eda', 'goals')
        );
    }

    public function evaluation($id_user, $year, $id_evaluation)
    {
        $user = User::find($id_user);
        $evaluation = Evaluation::find($id_evaluation);
        $years = Year::orderBy('name', 'desc')->get();
        $year = Year::find($year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $year->id)->first();
        $goals = [];

        if ($eda) {
            $goals = Goal::where('id_eda', $eda->id)->get();
        }

        return view(
            'pages.edas.user.eda.evaluation',
            compact('user', 'years', 'year', 'eda', 'goals', 'evaluation')
        );
    }
}
