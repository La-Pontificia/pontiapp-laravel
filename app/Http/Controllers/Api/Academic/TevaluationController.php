<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Academic\TeAnswer;
use App\Models\Academic\Tevaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TevaluationController extends Controller
{
    public function index(Request $req)
    {
        $match = Tevaluation::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $groupId = $req->query('groupId');
        $periodId = $req->query('periodId');
        $paginate = $req->query('paginate') === 'true';
        if ($groupId) $match->where('groupId', $groupId);
        if ($periodId) $match->orWhereHas('sectionCourse', function ($query) use ($periodId) {
            $query->whereHas('section', function ($subQuery) use ($periodId) {
                $subQuery->where('periodId', $periodId);
            });
        });
        if ($q) {
            $match->where(function ($subQuery) use ($q) {
                $subQuery->orWhereHas('teacher', function ($subQuery) use ($q) {
                    $subQuery->where('username', 'like', "%$q%")
                        ->orWhere('firstNames', 'like', "%$q%")
                        ->orWhere('documentId', 'like', "%$q%")
                        ->orWhere('lastNames', 'like', "%$q%")
                        ->orWhere('displayName', 'like', "%$q%");
                })->orWhereHas('sectionCourse', function ($subQuery) use ($q) {
                    $subQuery->whereHas('section', function ($subQuery) use ($q) {
                        $subQuery->where('code', 'like', "%$q%");
                    })->orWhereHas('planCourse', function ($subQuery) use ($q) {
                        $subQuery->whereHas('course', function ($subQuery) use ($q) {
                            $subQuery->where('code', 'like', "%$q%")
                                ->orWhere('name', 'like', "%$q%");
                        });
                    });
                });
            });
        }

        $data = $paginate ? $match->paginate(25) :  $match->get();
        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'trackingTime', 'created_at']) +
                ['evaluator' => $item->evaluator ? $item->evaluator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['sectionCourse' =>  [
                    'planCourse' =>  [
                        'course' => $item->sectionCourse->planCourse?->course?->only(['name', 'code',]),
                    ],
                ]] +
                ['teacher' => $item->teacher ? $item->teacher->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username', 'fullName']) : null];
        });
        return response()->json(
            $paginate ? [
                ...$data->toArray(),
                'data' => $graphed,
            ] : $graphed
        );
    }

    public function store(Request $req)
    {
        $req->validate([
            'groupId' => 'required|string',
            'sectionCourseId' => 'required|string',
            'teacherId' => 'required|string',
            'scheduleId' => 'required|string',
            'evaluationNumber' => 'required|integer',
            'trackingTime' => 'required|date',
            'branchId' => 'required|string',
            'answers' => 'required|array',
        ]);
        $period = Tevaluation::where('evaluationNumber', $req->evaluationNumber)
            ->where('groupId', $req->groupId)
            ->where('sectionCourseId', $req->sectionCourseId)
            ->where('teacherId', $req->teacherId)
            ->first();

        if ($period) return response()->json('Ya se hizo la evaluacion N° ' . $req->evaluationNumber . ' del docente y curso seleccionado, por favor verifique los datos e intente nuevamente.', 400);

        $data = Tevaluation::create([
            'name' => $req->name,
            'groupId' => $req->groupId,
            'sectionCourseId' => $req->sectionCourseId,
            'teacherId' => $req->teacherId,
            'scheduleId' => $req->scheduleId,
            'evaluationNumber' => $req->evaluationNumber,
            'trackingTime' => $req->trackingTime,
            'branchId' => $req->branchId,
            'evaluatorId' => Auth::id(),
            'creatorId' => Auth::id(),
        ]);

        // for each answer, create a new record in the answers table
        foreach ($req->answers as $answer) {
            TeAnswer::create([
                'teId' => $data->id,
                'questionId' => $answer['questionId'],
                'answer' => $answer['answer'],
            ]);
        }

        return response()->json($data);
    }

    public function update(Request $req, $id)
    {

        return response()->json('Updated');
    }

    public function delete($id)
    {
        $tevaluation = Tevaluation::findOrFail($id);
        TeAnswer::where('teId', $id)->delete();
        $tevaluation->delete();
        return response()->json('Data deleted');
    }

    public function one($id)
    {
        $tevaluation = Tevaluation::findOrFail($id);
        if (!$tevaluation) return response()->json('Data not found', 404);
        $group = $tevaluation->group;

        return response()->json(
            $tevaluation->only(['id', 'trackingTime', 'created_at']) +
                ['evaluator' => $tevaluation->evaluator ? $tevaluation->evaluator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['sectionCourse' =>  [
                    'planCourse' =>  [
                        'course' => $tevaluation->sectionCourse->planCourse?->course?->only(['name', 'code',]),
                    ],
                ]] +
                ['teacher' => $tevaluation->teacher ? $tevaluation->teacher->only(['id', 'firstNames', 'lastNames', 'displayName', 'photoURL', 'username', 'fullName']) : null] +
                [
                    'categories' => $group->categories->sortBy('order')->values()->map(function ($item) use ($tevaluation) {
                        return $item->only(['id', 'name', 'order']) +
                            ['blocks' => $item->blocks->sortBy('order')->values()->map(function ($block) use ($tevaluation) {
                                return $block->only(['id', 'name', 'order']) +
                                    ['questions' => $block->questions->sortBy('order')->values()->map(function ($question) use ($tevaluation) {
                                        $answer = $tevaluation->answers->where('questionId', $question->id)->first();
                                        $option = $answer ? $question->options->where('value', $answer->answer)->first() : null;

                                        return $question->only(['id', 'order', 'question', 'type']) +
                                            [
                                                'option' => $option ? $option->only(['id', 'value', 'name']) : null,
                                                'answer' => $answer ? $answer->only(['id', 'answer']) : null
                                            ];
                                    })];
                            })];
                    })
                ]
        );
    }
}
