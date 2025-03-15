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
        $match = EventRecord::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $eventId = $req->query('eventId');
        $businessUnitId = $req->query('businessUnitId');
        $paginate = $req->query('paginate') === 'true';

        if ($eventId) $match->where('eventId', $eventId);
        if ($businessUnitId) $match->where('businessUnitId', $businessUnitId);

        if ($q) $match->where('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('fullName', 'like', "%$q%")
            ->orWhere('documentId', 'like', "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'documentId', 'career', 'firstNames', 'lastNames', 'fullName', 'created_at']) +
                ['event' => $item->event ? $item->event->only(['id', 'name']) : null] +
                ['businessUnit' => $item->businessUnit ? $item->businessUnit->only(['id', 'name', 'logoURL']) : null];
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
