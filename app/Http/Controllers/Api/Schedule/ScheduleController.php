<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Http\Controllers\Controller;
use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
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
        $schedule->archived = true;
        $schedule->endDate = $req->endDate;
        $schedule->save();
        return response()->json('Schedule archived successfully');
    }

    public function store(Request $req)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'from' => 'required|date',
            'to' => 'required|date',
            'assistTerminalId' => 'required',
            'days' => 'required|array',
            'startDate' => 'required|date',
        ]);
        $schedule = new UserSchedule();
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->assistTerminalId = $req->assistTerminalId;
        $schedule->days = $req->days;
        $schedule->startDate = $req->startDate;
        $schedule->title = $req->title ?? '-';
        $schedule->createdBy = Auth::id();
        $schedule->save();
        return response()->json('Schedule created successfully');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'from' => 'required|date',
            'to' => 'required|date',
            'assistTerminalId' => 'required',
            'days' => 'required|array',
            'startDate' => 'required|date',
        ]);
        $schedule = UserSchedule::find($id);
        $schedule->userId = $req->userId;
        $schedule->from = $req->from;
        $schedule->to = $req->to;
        $schedule->assistTerminalId = $req->assistTerminalId;
        $schedule->days = $req->days;
        $schedule->startDate = $req->startDate;
        $schedule->title = $req->title ?? '-';
        $schedule->updatedBy = Auth::id();
        $schedule->save();
        return response()->json('Schedule updated successfully');
    }
}
