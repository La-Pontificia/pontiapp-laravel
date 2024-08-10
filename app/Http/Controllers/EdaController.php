<?php

namespace App\Http\Controllers;

use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\JobPosition;
use App\Models\QuestionnaireTemplate;
use App\Models\Role;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;

class EdaController  extends Controller
{

    public function index(Request $request)
    {
        $cuser = User::find(auth()->user()->id);
        $match = User::orderBy('created_at', 'desc');
        $query = $request->get('q');
        $job_position = $request->get('job_position');
        $job_positions = JobPosition::all();
        $role = $request->get('role');
        $users = [];

        if ($cuser->has('edas:show') && !$cuser->has('edas:show_all')) {
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

    public function reports()
    {
        return view('modules.edas.reports.+page');
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
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $current_year->id)->first();
        $user = User::find($id_user);
        return view(
            'modules.edas.slug.+page',
            compact('years', 'current_year', 'eda', 'user')
        );
    }

    public function goals($id_user, $id_year)
    {
        $years = Year::orderBy('name', 'desc')->get();
        $eda = Eda::where('id_user', $id_user)->where('id_year', $id_year)->first();

        if (!$eda) return view('+500', ['error' => 'Eda not found']);

        $current_year = Year::find($id_year);

        return view(
            'modules.edas.slug.goals.+page',
            compact('years',  'eda',  'current_year')
        );
    }

    public function evaluation($id_user, $id_year, $id_evaluation)
    {
        $evaluation = Evaluation::find($id_evaluation);
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $current_year->id)->first();

        // validate
        if (!$eda) return view('+500', ['error' => 'Eda not found']);
        if (!$evaluation) return view('+500', ['error' => 'Evaluation not found']);

        return view(
            'modules.edas.slug.evaluation.+page',
            compact('years', 'current_year', 'eda', 'evaluation')
        );
    }

    public function ending($id_user, $id_year)
    {
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $id_year)->first();

        $evaluations = $eda->evaluations;

        // validate
        if (!$eda) return view('+500', ['error' => 'Eda not found']);
        if (!$eda->approved) return view('+500', ['error' => 'Eda not approved']);
        if (!$current_year) return view('+500', ['error' => 'Year not found']);
        if (!$evaluations->last()->closed) return view('+500', ['error' => 'Last evaluation not closed']);

        return view('modules.edas.slug.ending.+page', [
            'current_year' => $current_year,
            'eda' => $eda,
            'years' => $years,
            'evaluations' => $evaluations,
        ]);
    }

    public function questionnaires($id_user, $id_year)
    {
        $years = Year::orderBy('name', 'desc')->get();
        $current_year = Year::find($id_year);
        $eda = Eda::where('id_user', $id_user)->where('id_year', $id_year)->first();

        $collaborator_questionnaire = QuestionnaireTemplate::where('for', 'collaborators')->first();
        $supervisor_questionnaire = QuestionnaireTemplate::where('for', 'supervisors')->first();

        // validate
        if (!$eda) return view('+500', ['error' => 'Eda not found']);
        if (!$current_year) return view('+500', ['error' => 'Current year not found']);

        return view(
            'modules.edas.slug.questionnaires.+page',
            [
                'years' => $years,
                'eda' => $eda,
                'current_year' => $current_year,
                'collaborator_questionnaire' => $collaborator_questionnaire,
                'supervisor_questionnaire' => $supervisor_questionnaire,
            ]
        );
    }
}
