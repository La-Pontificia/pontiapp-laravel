<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Jobs\EventRecord as JobsEventRecord;
use App\Models\EventRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRecordController extends Controller
{

    public function index(Request $req)
    {
        $match = EventRecord::orderBy('created_at', 'asc');

        $q = $req->query('q');
        $eventId = $req->query('eventId');
        $businessUnitId = $req->query('businessUnitId');
        $relationship = explode(',', $req->query('relationship', ''));

        if (in_array('event', $relationship)) $match->with('event');
        if (in_array('business', $relationship)) $match->with('business');

        if ($eventId) $match->where('eventId', $eventId);
        if ($businessUnitId) $match->where('businessUnitId', $businessUnitId);

        if ($q) $match->where('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('fullName', 'like', "%$q%")
            ->orWhere('documentId', 'like', "%$q%");

        $records = $match->paginate();

        return response()->json($records);
    }

    public function store(Request $req)
    {
        $req->validate([
            'documentId' => 'required|string',
            'firstNames' => 'nullable|string',
            'lastNames' => 'nullable|string',
            'fullName' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|string',
            'period' => 'nullable|string',
            'career' => 'nullable|string',
            'eventId' => 'required|string',
            'businessUnitId' => 'required|string',
        ]);

        EventRecord::create([
            'documentId' => $req->get('documentId'),
            'firstNames' => $req->get('firstNames'),
            'lastNames' => $req->get('lastNames'),
            'fullName' => $req->get('fullName'),
            'email' => $req->get('email'),
            'gender' => $req->get('gender'),
            'period' => $req->get('period'),
            'career' => $req->get('career'),
            'eventId' => $req->get('eventId'),
            'businessUnitId' => $req->get('businessUnitId'),
            'created_at' => now(),
        ]);

        return response()->json('Ok');
    }

    public function distroy($id)
    {
        $record = EventRecord::find($id);
        $record->delete();

        return response()->json('OK');
    }

    public function report(Request $req)
    {
        $eventId = $req->query('eventId');
        $businessUnitId = $req->query('businessUnitId');
        if (!$eventId) return response()->json('Seleccione un evento');
        JobsEventRecord::dispatch($eventId,  $businessUnitId, Auth::id());
        return response()->json('Ok');
    }
}
