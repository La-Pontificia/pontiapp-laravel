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
        $archived = $req->query('archived');

        $match = UserSchedule::where('userId', $user->id)->orderBy('from', 'asc');

        if ($archived == 'true') {
            $match->where('archived', true);
        }

        if ($archived == 'false') {
            $match->where('archived', false);
        }

        $limit = $req->query('limit', 10);
        $includes = explode(',', $req->query('relationship'));
        if (in_array('terminal', $includes)) $match->with('terminal');
        $schedules = $match->limit($limit)->get();
        return response()->json(
            $schedules->map(function ($schedule) {
                return $schedule->only(['id', 'from', 'to', 'days', 'tolerance', 'archived', 'title', 'startDate', 'endDate']) + ['terminal' => $schedule->terminal?->only(['id', 'name'])];
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
            'endDate' => 'date|required',
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
            'from' => 'required|date',
            'to' => 'required|date',
            'tolerance' => 'required|numeric',
            'days' => 'required|array',
            'startDate' => 'required|date',
        ]);
        $schedule = new UserSchedule();
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->tolerance = $req->tolerance;
        $schedule->days = $req->days;
        $schedule->startDate = $req->startDate;
        $schedule->creatorId = Auth::id();
        $schedule->save();
        return response()->json('Schedule created successfully');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'from' => 'required|date',
            'to' => 'required|date',
            'days' => 'required|array',
            'tolerance' => 'required|numeric',
            'startDate' => 'required|date',
        ]);
        $schedule = UserSchedule::find($id);
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->days = $req->days;
        $schedule->tolerance = $req->tolerance;
        $schedule->startDate = $req->startDate;
        $schedule->updaterId = Auth::id();
        $schedule->save();
        return response()->json('Schedule updated successfully');
    }
}
