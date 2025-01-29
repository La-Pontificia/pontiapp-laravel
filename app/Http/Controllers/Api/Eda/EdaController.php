<?php

namespace App\Http\Controllers\Api\Eda;

use App\Http\Controllers\Controller;
use App\Models\Eda;
use App\Models\EdaEvaluation;
use Illuminate\Support\Facades\Auth;

class EdaController  extends Controller
{

    public function slug($slug)
    {
        $eda = Eda::find($slug);
        return response()->json($eda);
    }

    public function edaByCollaboratorAndYear($slugCollaborator, $slugYear)
    {
        $eda = Eda::whereHas('user', function ($q) use ($slugCollaborator) {
            $q->where('username', $slugCollaborator)->orWhere('id', $slugCollaborator)->orWhere('email', $slugCollaborator);
        })->where('yearId', $slugYear)->first();

        return  $eda ? response()->json(
            $eda->only([
                'id',
                'created_at',
                'updated_at',
                'status',
                'approvedAt',
                'closedAt',
                'sentAt',
            ]) + [
                'creator' => $eda->creator?->only(['id', 'displayName', 'firstNames', 'lastNames', 'username']),
                'managed' => $eda->managed?->only(['id', 'displayName', 'firstNames', 'lastNames', 'username']),
                'approver' => $eda->approver?->only(['id', 'displayName', 'firstNames', 'lastNames', 'username']),
                'closer' => $eda->closer?->only(['id', 'displayName', 'firstNames', 'lastNames', 'username']),
                'sender' => $eda->sender?->only(['id', 'displayName', 'firstNames', 'lastNames', 'username']),
                'evaluations' => [
                    1 => $eda->evaluations->where('number', 1)->first()?->only(['id', 'qualification', 'selftQualification', 'closedAt']),
                    2 => $eda->evaluations->where('number', 2)->first()?->only(['id', 'qualification', 'selftQualification', 'closedAt']),
                ],
                'countObjetives' => $eda->objetives->count(),
            ]

        ) : response("null")->header('Content-Type', 'application/json');;
    }

    public function createEdaByCollaboratorAndYear($slugCollaborator, $slugYear)
    {
        $eda = new Eda();
        $eda->userId = $slugCollaborator;
        $eda->yearId = $slugYear;
        $eda->creatorId = Auth::id();
        $eda->save();

        // create evaluations
        $count = [1, 2];
        foreach ($count as $number) {
            $edaEvaluation = new EdaEvaluation();
            $edaEvaluation->number = $number;
            $edaEvaluation->edaId = $eda->id;
            $edaEvaluation->save();
        }

        return response()->json('Ok');
    }

    public function approve($slug)
    {
        $eda = Eda::find($slug);
        $eda->approvedAt = now();
        $eda->approverId = Auth::id();
        $eda->save();

        return response()->json('Ok');
    }

    public function close($slug)
    {
        $eda = Eda::find($slug);
        $eda->closedAt = now();
        $eda->closerId = Auth::id();
        $eda->save();

        return response()->json('Ok');
    }
}
