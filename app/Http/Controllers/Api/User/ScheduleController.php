<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $req, $slug)
    {
        $user =  User::where('id', $slug)->orWhere('username', $slug)->orWhere('email', $slug)->orWhere('documentId', $slug)->first();

        if (!$user) {
            return response()->json('not_found', 404);
        }

        $archived = $req->query('archived');
        $type = $req->query('type');


        $match = UserSchedule::where('userId', $user->id)->orderBy('from', 'asc');

        if ($type) {
            $match->where('type', $type);
        }

        if ($archived == 'true') {
            $match->where('archived', true);
        }

        if ($archived == 'false') {
            $match->where('archived', false);
        }

        $limit = $req->query('limit', 10);
        $schedules = $match->limit($limit)->get();
        return response()->json(
            $schedules->map(function ($schedule) {
                return array_merge(
                    $schedule->only(['id', 'from', 'to', 'days', 'tolerance', 'archived', 'title', 'startDate', 'type', 'endDate']),
                    ['dates' => $schedule->dates]
                );
            })
        );
    }

    public function delete($id)
    {
        $schedule = UserSchedule::find($id);
        $schedule->delete();
        return response()->json('Schedule deleted successfully');
    }

    public function archive(Request $req, $id)
    {
        $req->validate([
            'endDate' => 'date|nullable',
        ]);
        $schedule = UserSchedule::find($id);
        $isArchived = $schedule->archived;

        $schedule->archived = $isArchived ? false : true;
        $schedule->endDate = $isArchived ? null : $req->endDate;
        $schedule->save();
        return response()->json('Schedule archived successfully');
    }

    public function store(Request $req)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'type' => 'string',
            'from' => 'required|date',
            'to' => 'required|date',
            'tolerance' => 'required|numeric',
            'days' => 'required|array',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date',
        ]);
        $schedule = new UserSchedule();
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->tolerance = $req->tolerance;
        $schedule->type = 'available';
        $schedule->days = $req->days;
        $schedule->startDate = $req->startDate;
        $schedule->endDate = $req->endDate;
        $schedule->archived = false;
        $schedule->creatorId = Auth::id();
        $schedule->save();
        return response()->json('Schedule created successfully');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'type' => 'string',
            'from' => 'required|date',
            'to' => 'required|date',
            'days' => 'required|array',
            'tolerance' => 'required|numeric',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date',
        ]);
        $schedule = UserSchedule::find($id);
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->days = $req->days;
        $schedule->tolerance = $req->tolerance;
        $schedule->startDate = $req->startDate;
        $schedule->endDate = $req->endDate;
        $schedule->updaterId = Auth::id();
        $schedule->save();
        return response()->json('Schedule updated successfully');
    }
}
