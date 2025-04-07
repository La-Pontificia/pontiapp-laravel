<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Jobs\TmTr;
use App\Models\Academic\TeacherTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherTrackingController extends Controller
{
    public function index(Request $req)
    {
        $match = TeacherTracking::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $sectionId = $req->query('sectionId');
        $periodId = $req->query('periodId');
        $academicProgramId = $req->query('academicProgramId');
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        if ($sectionId) $match->whereHas('sectionCourse', function ($query) use ($sectionId) {
            $query->where('sectionId', $sectionId);
        });

        if ($periodId) $match->whereHas('sectionCourse', function ($query) use ($periodId) {
            $query->whereHas('section', function ($query) use ($periodId) {
                $query->where('periodId', $periodId);
            });
        });

        if ($academicProgramId) $match->whereHas('sectionCourse', function ($query) use ($academicProgramId) {
            $query->whereHas('section', function ($query) use ($academicProgramId) {
                $query->where('programId', $academicProgramId);
            });
        });

        if ($startDate) $match->where('date', '>=', $startDate);
        if ($endDate) $match->where('date', '<=', $endDate);

        if ($q) $match->whereHas('sectionCourse', function ($query) use ($q) {
            $query->whereHas('section', function ($query) use ($q) {
                $query->where('code', 'like', "%$q%");
            })->orWhereHas('planCourse', function ($query) use ($q) {
                $query->where('name', 'like', "%$q%");
            });
        });

        $data = $match->paginate(25);
        return response()->json([
            ...$data->toArray(),
            'data' => $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'sectionCourse' => $item->sectionCourse?->only(['id']) + [
                        'section' => $item->sectionCourse->section?->only(['id', 'code']) + [
                            'period' => $item->sectionCourse->section->period?->only(['id', 'name']),
                            'program' => $item->sectionCourse->section->program?->only(['id', 'name']),
                        ],
                        'planCourse' => $item->sectionCourse->planCourse?->only(['id', 'name']),
                    ],
                    'evaluator' => $item->evaluator?->only(['id', 'firstNames', 'lastNames', 'username', 'photoURL', 'displayName']),
                ];
            }),
        ]);
    }

    public function report(Request $req)
    {
        $q = $req->query('q');
        $section = $req->query('section');
        $period = $req->query('period');
        $academicProgram = $req->query('academicProgram');
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        TmTr::dispatch($q, $section, $period, $academicProgram, $startDate, $endDate, Auth::id());

        return response()->json('Report is being generated');
    }

    public function one($id)
    {
        $data = TeacherTracking::find($id);
        return response()->json([
            ...$data->toArray(),
            'businessUnit' => $data->businessUnit?->only(['id', 'name']),
            'branch' => $data->branch?->only(['id', 'name']),
            'evaluator' => $data->evaluator?->only(['id', 'firstNames', 'lastNames', 'username', 'photoURL', 'displayName']),
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'sectionCourseId' => 'string|required',
            'scheduleId' => 'string|required',
            'branchId' => 'string|required',
            'date' => 'date|required',
            'trackingTime' => 'date|required',
            'evaluationNumber' => 'numeric|required',

            'er1Json' => 'array|required',
            'er1a' => 'numeric|required',
            'er1b' => 'numeric|required',
            'er1Obtained' => 'numeric|required',
            'er1Qualification' => 'string|required',

            'er2Json' => 'array|required',
            'er2a1' => 'numeric|required',
            'er2a2' => 'numeric|required',
            'er2aObtained' => 'numeric|required',
            'er2b1' => 'numeric|required',
            'er2b2' => 'numeric|required',
            'er2bObtained' => 'numeric|required',
            'er2Total' => 'numeric|required',
            'er2FinalGrade' => 'numeric|required',
            'er2Qualification' => 'string|required',

            'aditional1' => 'string|nullable',
            'aditional2' => 'string|nullable',
            'aditional3' => 'string|nullable',
        ]);
        TeacherTracking::create([
            'sectionCourseId' => $req->sectionCourseId,
            'scheduleId' => $req->scheduleId,
            'branchId' => $req->branchId,
            'date' => $req->date,
            'trackingTime' => $req->trackingTime,
            'evaluationNumber' => $req->evaluationNumber,
            'evaluatorId' => Auth::id(),

            'er1Json' => $req->er1Json,
            'er1a' => $req->er1a,
            'er1b' => $req->er1b,
            'er1Obtained' => $req->er1Obtained,
            'er1Qualification' => $req->er1Qualification,

            'er2Json' => $req->er2Json,
            'er2a1' => $req->er2a1,
            'er2a2' => $req->er2a2,
            'er2aObtained' => $req->er2aObtained,
            'er2b1' => $req->er2b1,
            'er2b2' => $req->er2b2,
            'er2bObtained' => $req->er2bObtained,
            'er2Total' => $req->er2Total,
            'er2FinalGrade' => $req->er2FinalGrade,
            'er2Qualification' => $req->er2Qualification,
            'aditional1' => $req->aditional1,

            'aditional2' => $req->aditional2,
            'aditional3' => $req->aditional3,
        ]);
        return response()->json('Data created');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'sectionCourseId' => 'string|required',
            'scheduleId' => 'string|required',
            'branchId' => 'string|required',
            'date' => 'date|required',
            'trackingTime' => 'date|required',
            'evaluationNumber' => 'numeric|required',

            'er1Json' => 'array|required',
            'er1a' => 'numeric|required',
            'er1b' => 'numeric|required',
            'er1Obtained' => 'numeric|required',
            'er1Qualification' => 'string|required',

            'er2Json' => 'array|required',
            'er2a1' => 'numeric|required',
            'er2a2' => 'numeric|required',
            'er2aObtained' => 'numeric|required',
            'er2b1' => 'numeric|required',
            'er2b2' => 'numeric|required',
            'er2bObtained' => 'numeric|required',
            'er2Total' => 'numeric|required',
            'er2FinalGrade' => 'numeric|required',
            'er2Qualification' => 'string|required',

            'aditional1' => 'string|nullable',
            'aditional2' => 'string|nullable',
            'aditional3' => 'string|nullable',
        ]);

        $data = TeacherTracking::find($id);

        $data->update([
            'sectionCourseId' => $req->sectionCourseId,
            'scheduleId' => $req->scheduleId,
            'branchId' => $req->branchId,
            'date' => $req->date,
            'trackingTime' => $req->trackingTime,
            'evaluationNumber' => $req->evaluationNumber,

            'er1Json' => $req->er1Json,
            'er1a' => $req->er1a,
            'er1b' => $req->er1b,
            'er1Obtained' => $req->er1Obtained,
            'er1Qualification' => $req->er1Qualification,

            'er2Json' => $req->er2Json,
            'er2a1' => $req->er2a1,
            'er2a2' => $req->er2a2,
            'er2aObtained' => $req->er2aObtained,
            'er2b1' => $req->er2b1,
            'er2b2' => $req->er2b2,
            'er2bObtained' => $req->er2bObtained,
            'er2Total' => $req->er2Total,
            'er2FinalGrade' => $req->er2FinalGrade,
            'er2Qualification' => $req->er2Qualification,
            'aditional1' => $req->aditional1,

            'aditional2' => $req->aditional2,
            'aditional3' => $req->aditional3,
        ]);
        return response()->json('Data updated');
    }

    public function delete($id)
    {
        $data = TeacherTracking::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
