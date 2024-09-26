<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Eda;
use App\Models\Evaluation;
use App\Models\JobPosition;
use App\Models\QuestionnaireTemplate;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Year;
use Illuminate\Http\Request;

class EdaController  extends Controller
{


    public function index(Request $request, $isExport = false)
    {
        $cuser = User::find(auth()->user()->id);
        $match = Eda::orderBy('created_at', 'desc');
        $query = $request->get('q');
        $status = $request->get('status');
        $year_id = $request->get('year');

        $job_position = $request->get('job_position');
        $department = $request->get('department');

        if ($status && $status == 'sent') {
            $match->where('sent', '!=', null);
        }
        if ($status && $status == 'approved') {
            $match->where('approved', '!=', null);
        }
        if ($status && $status == 'closed') {
            $match->where('closed', '!=', null);
        }

        if ($status && $status == 'not-sent') {
            $match->where('sent', '==', null);
        }
        if ($status && $status == 'not-approved') {
            $match->where('approved', '==', null);
        }
        if ($status && $status == 'not-closed') {
            $match->where('closed', '==', null);
        }

        if ($year_id) {
            $match->where('id_year', $year_id);
        }

        if ($query) {
            $match->whereHas('user', function ($q) use ($query) {
                $q->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%')
                    ->orWhere('dni', 'like', '%' . $query . '%');
            });
        }

        if ($job_position) {
            $match->whereHas('user', function ($q) use ($job_position) {
                $q->whereHas('role_position', function ($q) use ($job_position) {
                    $q->where('id_job_position', $job_position);
                });
            });
        }

        if ($department) {
            $match->whereHas('user', function ($q) use ($department) {
                $q->whereHas('role_position', function ($q) use ($department) {
                    $q->whereHas('department', function ($q) use ($department) {
                        $q->where('id', $department);
                    });
                });
            });
        }

        if ($cuser->has('edas:show') && !$cuser->has('edas:show_all')) {
            $match->whereHas('user', function ($q) use ($cuser) {
                $q->where('supervisor_id', $cuser->id);
            });
        }

        if ($isExport) {
            return $match;
        }

        $edas = $match->paginate();
        $years = Year::orderBy('name', 'desc')->get();
        $job_positions = JobPosition::all();
        $departments = Department::all();

        return view('modules.edas.(group).+page', compact('edas', 'years', 'job_positions', 'departments'))
            ->with('i', (request()->input('page', 1) - 1) * $edas->perPage());
    }

    public function export(Request $request)
    {
        $match = $this->index($request, true);
        $all = $match->get();
        $type = $request->type;

        $edas = [];

        foreach ($all as $eda) {
            $evaluation01 = $eda->evaluations->where('number', 1)->first();
            $evaluation02 = $eda->evaluations->where('number', 2)->first();

            if ($type === 'basic') {

                $edas[] = [
                    'year' => $eda->year->name,
                    'full_name' => $eda->user->first_name . ', ' . $eda->user->last_name,
                    'dni' => $eda->user->dni,
                    'role' => $eda->user->role_position->name,
                    'job_position' => $eda->user->role_position->job_position->name,
                    'closed' => $eda->closed,
                    'goals' => [
                        'count' => $eda->goals->count(),
                        'sent' => $eda->sent,
                        'approved' => $eda->approved,
                    ],
                    'evaluations' => [
                        '1' => [
                            'qualification' => $evaluation01->qualification,
                            'self_qualification' => $evaluation01->self_qualification,
                            'closed' => $evaluation01->closed,
                            'feedback' => $evaluation01->feedback_at ? $evaluation01->feedback_at : null,
                        ],
                        '2' => [
                            'qualification' => $evaluation02->qualification,
                            'self_qualification' => $evaluation02->self_qualification,
                            'closed' => $evaluation02->closed,
                            'feedback' => $evaluation02->feedback_at ? $evaluation02->feedback_at : null,
                        ]
                    ],
                    'questionnaires' => [
                        'collaborator' => [
                            'resolved' => $eda->collaboratorQuestionnaire ? $eda->collaboratorQuestionnaire->created_at : null,
                            // 'resolved_by' => $eda->collaboratorQuestionnaire ? $eda->collaboratorQuestionnaire->answeredBy->first_name . ' ' . $eda->collaboratorQuestionnaire->answeredBy->last_name : null,
                        ],
                        'supervisor' => [
                            'resolved' => $eda->supervisorQuestionnaire ? $eda->supervisorQuestionnaire->created_at : null,
                            // 'resolved_by' => $eda->supervisorQuestionnaire ? $eda->supervisorQuestionnaire->answeredBy->first_name . ' ' . $eda->supervisorQuestionnaire->answeredBy->last_name : null,
                        ]
                    ]
                ];
            }

            if ($type === 'advanced') {

                $edas[] = [
                    'year' => $eda->year->name,
                    'full_name' => $eda->user->first_name . ' ' . $eda->user->last_name,
                    'dni' => $eda->user->dni,
                    'role' => $eda->user->role_position->name,
                    'job_position' => $eda->user->role_position->job_position->name,
                    'closed' => $eda->closed ? true : false,
                    'closed_by' => $eda->closedBy ? $eda->closedBy->first_name . ' ' . $eda->closedBy->last_name : null,
                    'created_at' => $eda->created_at,
                    'created_by' => $eda->createdBy ? $eda->createdBy->first_name . ' ' . $eda->createdBy->last_name : null,

                    'goals' => [
                        'count' => $eda->goals->count(),
                        'sent' => $eda->sent ? true : false,
                        'sent_at' => $eda->sent,
                        'approved' => $eda->approved ? true : false,
                        'items' => $eda->goals->map(function ($goal) {
                            return [
                                'title' => $goal->title,
                                'description' => $goal->description,
                                'indicators' => $goal->indicators,
                                'percentage' => $goal->percentage,
                                'comments' => $goal->comments,
                            ];
                        }),
                    ],
                    'evaluations' => [
                        '1' => [
                            'qualification' => $evaluation01->qualification,
                            'qulification_by' => $evaluation01->qualifiedBy ? $evaluation01->qualifiedBy->first_name . ' ' . $evaluation01->qualifiedBy->last_name : null,
                            'self_qualification' => $evaluation01->self_qualification,
                            'self_qualification_by' => $evaluation01->selfRatedBy ? $evaluation01->selfRatedBy->first_name . ' ' . $evaluation01->selfRatedBy->last_name : null,
                            'closed' => $evaluation01->closed,
                            'closed_by' => $evaluation01->closedBy ? $evaluation01->closedBy->first_name . ' ' . $evaluation01->closedBy->last_name : null,
                            'feedback' => $evaluation01->feedback ? true : false,
                            'feedback_score' => $evaluation01->feedback_score,
                            'feedback_by' => $evaluation01->feedbackBy ? $evaluation01->feedbackBy->first_name . ' ' . $evaluation01->feedbackBy->last_name : null,
                            'items' => $evaluation01->goalsEvaluations->map(function ($goalEvaluation) {
                                return [
                                    'goal' => $goalEvaluation->goal->title,
                                    'qualification' => $goalEvaluation->qualification,
                                    'self_qualification' => $goalEvaluation->self_qualification,
                                ];
                            }),
                        ],
                        '2' => [
                            'qualification' => $evaluation02->qualification,
                            'qulification_by' => $evaluation02->qualifiedBy ? $evaluation02->qualifiedBy->first_name . ' ' . $evaluation02->qualifiedBy->last_name : null,
                            'self_qualification' => $evaluation02->self_qualification,
                            'self_qualification_by' => $evaluation02->selfRatedBy ? $evaluation02->selfRatedBy->first_name . ' ' . $evaluation02->selfRatedBy->last_name : null,
                            'closed' => $evaluation02->closed,
                            'closed_by' => $evaluation02->closedBy ? $evaluation02->closedBy->first_name . ' ' . $evaluation02->closedBy->last_name : null,
                            'feedback' => $evaluation02->feedback ? true : false,
                            'feedback_score' => $evaluation02->feedback_score,
                            'feedback_by' => $evaluation02->feedbackBy ? $evaluation02->feedbackBy->first_name . ' ' . $evaluation02->feedbackBy->last_name : null,
                            'items' => $evaluation02->goalsEvaluations->map(function ($goalEvaluation) {
                                return [
                                    'goal' => $goalEvaluation->goal->title,
                                    'qualification' => $goalEvaluation->qualification,
                                    'self_qualification' => $goalEvaluation->self_qualification,
                                ];
                            }),
                        ]
                    ],
                    'questionnaires' => [
                        'collaborator' => [
                            'count' => $eda->collaboratorQuestionnaire ? $eda->collaboratorQuestionnaire->answers->count() : 0,
                            'resolved' => $eda->collaboratorQuestionnaire ? $eda->collaboratorQuestionnaire->created_at : null,
                            'resolved_by' => $eda->collaboratorQuestionnaire ? $eda->collaboratorQuestionnaire->answeredBy->first_name . ' ' . $eda->collaboratorQuestionnaire->answeredBy->last_name : null,
                        ],
                        'supervisor' => [
                            'count' => $eda->supervisorQuestionnaire ? $eda->supervisorQuestionnaire->answers->count() : 0,
                            'resolved' => $eda->supervisorQuestionnaire ? $eda->supervisorQuestionnaire->created_at : null,
                            'resolved_by' => $eda->supervisorQuestionnaire ? $eda->supervisorQuestionnaire->answeredBy->first_name . ' ' . $eda->supervisorQuestionnaire->answeredBy->last_name : null,
                        ]
                    ]
                ];
            }
        }

        return response()->json($edas);
    }

    public function collaborators(Request $request)
    {
        $role = $request->get('role');
        $cuser = User::find(auth()->user()->id);
        $match = User::orderBy('created_at', 'desc');
        $query = $request->get('q');
        $job_position = $request->get('job_position');
        $status = $request->get('status');
        $department = $request->get('department');
        $job_positions = JobPosition::all();
        $user_roles = UserRole::all();

        if ($cuser->has('edas:show') && !$cuser->has('edas:show_all')) {
            $match->where('supervisor_id', $cuser->id);
        }

        // filters
        if ($status && $status == 'actives') {
            $match->where('status', true);
        }

        if ($status && $status == 'inactives') {
            $match->where('status', false);
        }

        if ($role) {
            $match->where('id_role_user', $role);
        }

        if ($job_position) {
            $match->whereHas('role_position', function ($q) use ($job_position) {
                $q->where('id_job_position', $job_position);
            });
        }

        if ($department) {
            $match->whereHas('role_position', function ($q) use ($department) {
                $q->whereHas('department', function ($q) use ($department) {
                    $q->where('id', $department);
                });
            });
        }

        if ($query) {
            $match->where('first_name', 'like', '%' . $query . '%')
                ->orWhere('last_name', 'like', '%' . $query . '%')
                ->orWhere('dni', 'like', '%' . $query . '%')
                ->get();
        }


        $jobPostions = JobPosition::all();
        $roles = Role::all();
        $user_roles = UserRole::all();
        $departments = Department::all();

        $users = $match->paginate();

        return view('modules.edas.(group).collaborators.+page', compact('users', 'job_positions', 'user_roles', 'departments', 'roles'))
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

        $collaborator_questionnaire = QuestionnaireTemplate::where('use_for', 'collaborators')->first();
        $supervisor_questionnaire = QuestionnaireTemplate::where('use_for', 'supervisors')->first();

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
