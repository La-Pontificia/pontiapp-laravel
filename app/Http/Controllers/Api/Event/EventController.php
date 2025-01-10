<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function all(Request $req)
    {
        $match = Event::orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('name', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%");

        if (in_array('creator', $relationship)) $match->with('creator');


        $events = $paginate === 'true' ? $match->paginate() : $match->get();

        if (in_array('recordsCount', $relationship)) {
            $events->map(function ($event) {
                $event->recordsCount = $event->recordsCount();
                return $event;
            });
        }

        return response()->json($events);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $event = Event::create([
            'name' => $req->name,
            'description' => $req->description,
            'date' => $req->date,
            'creatorId' => Auth::id(),
        ]);

        return response()->json($event);
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $event = Event::find($id);

        if (!$event) return response()->json('Event not found', 404);

        $event->update([
            'name' => $req->name,
            'description' => $req->description,
            'date' => $req->date,
            'updaterId' => Auth::id(),
        ]);

        return response()->json($event);
    }

    public function delete($id)
    {
        $event = Event::find($id);

        if ($event->records()->count() > 0) {
            return response()->json('Hay registros asociados a este evento', 400);
        }

        if (!$event) return response()->json('Event not found', 404);

        $event->delete();

        return response()->json('Event deleted');
    }
}
