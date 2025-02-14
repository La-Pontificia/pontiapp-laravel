<?php

namespace App\Http\Controllers\Api\Rm;

use App\Http\Controllers\Controller;
use App\Jobs\TmTr;
use App\Models\RmTTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RmTTrackingController extends Controller
{
    public function index(Request $req)
    {
        $match = RmTTracking::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $section = $req->query('section');
        $period = $req->query('period');
        $academicProgram = $req->query('academicProgram');
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        if ($section) $match->where('section', $section);
        if ($period) $match->where('period', $period);
        if ($academicProgram) $match->where('academicProgram', $academicProgram);
        if ($startDate) $match->where('date', '>=', $startDate);
        if ($endDate) $match->where('date', '<=', $endDate);

        if ($q) $match->where('teacherFullName', 'like', "%$q%")
            ->orWhere('teacherDocumentId', 'like', "%$q%")
            ->orWhere('section', 'like', "%$q%")
            ->orWhere('period', 'like', "%$q%");

        $data = $match->paginate(25);
        return response()->json([
            ...$data->toArray(),
            'data' => $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'teacherDocumentId' => $item->teacherDocumentId,
                    'teacherFullName' => $item->teacherFullName,
                    'academicProgram' => $item->academicProgram,
                    'period' => $item->period,
                    'course' => $item->course,
                    'section' => $item->section,
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
        $data = RmTTracking::find($id);
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
            'teacherDocumentId' => 'required|numeric|digits:8',
            'teacherFullName' => 'string|required',
            'period' => 'string|required',
            'cycle' => 'string|required',
            'section' => 'string|required',
            'classRoom' => 'string|required',
            'branchId' => 'string|required',
            'businessUnitId' => 'string|required',
            'area' => 'string|required',
            'academicProgram' => 'string|required',
            'course' => 'string|required',
            'date' => 'date|required',
            'evaluatorId' => 'string|required',
            'evaluationNumber' => 'numeric|required',
            'startOfClass' => 'date|required',
            'endOfClass' => 'date|required',
            'trackingTime' => 'date|required',
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
        $data = RmTTracking::create([
            'teacherDocumentId' => $req->teacherDocumentId,
            'teacherFullName' => $req->teacherFullName,
            'period' => $req->period,
            'cycle' => $req->cycle,
            'section' => $req->section,
            'classRoom' => $req->classRoom,
            'branchId' => $req->branchId,
            'businessUnitId' => $req->businessUnitId,
            'area' => $req->area,
            'academicProgram' => $req->academicProgram,
            'course' => $req->course,
            'date' => $req->date,
            'evaluatorId' => $req->evaluatorId,
            'evaluationNumber' => $req->evaluationNumber,
            'startOfClass' => $req->startOfClass,
            'endOfClass' => $req->endOfClass,
            'trackingTime' => $req->trackingTime,
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
            'teacherDocumentId' => 'required|numeric|digits:8',
            'teacherFullName' => 'string|required',
            'period' => 'string|required',
            'cycle' => 'string|required',
            'section' => 'string|required',
            'classRoom' => 'string|required',
            'branchId' => 'string|required',
            'businessUnitId' => 'string|required',
            'area' => 'string|required',
            'academicProgram' => 'string|required',
            'course' => 'string|required',
            'date' => 'date|required',
            'evaluatorId' => 'string|required',
            'evaluationNumber' => 'numeric|required',
            'startOfClass' => 'date|required',
            'endOfClass' => 'date|required',
            'trackingTime' => 'date|required',
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

        $data = RmTTracking::find($id);

        $data->update([
            'teacherDocumentId' => $req->teacherDocumentId,
            'teacherFullName' => $req->teacherFullName,
            'period' => $req->period,
            'cycle' => $req->cycle,
            'section' => $req->section,
            'classRoom' => $req->classRoom,
            'branchId' => $req->branchId,
            'businessUnitId' => $req->businessUnitId,
            'area' => $req->area,
            'academicProgram' => $req->academicProgram,
            'course' => $req->course,
            'date' => $req->date,
            'evaluatorId' => $req->evaluatorId,
            'evaluationNumber' => $req->evaluationNumber,
            'startOfClass' => $req->startOfClass,
            'endOfClass' => $req->endOfClass,
            'trackingTime' => $req->trackingTime,
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
        $data = RmTTracking::find($id);
        if (!$data) return response()->json('Data not found', 404);
        $data->delete();
        return response()->json('Data deleted');
    }
}
