<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $req)
    {
        $match = Event::orderBy('created_at', 'desc');
        $q = $req->query('q');
        $paginate = $req->query('paginate') === 'true';

        if ($q) $match->where('name', 'like', "%$q%")->orWhere('description', 'like', "%$q%");

        $data = $paginate ? $match->paginate(25) :  $match->get();

        $graphed = $data->map(function ($item) {
            return $item->only(['id', 'name', 'description', 'date', 'created_at']) +
                ['creator' => $item->creator ? $item->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $item->updater ? $item->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null];
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

    public function one($id)
    {
        $data = Event::find($id);
        if (!$data) return response()->json('not_found', 404);
        return response()->json(
            $data->only(['id', 'name', 'description', 'date', 'created_at']) +
                ['creator' => $data->creator ? $data->creator->only(['id', 'firstNames', 'lastNames', 'displayName']) : null] +
                ['updater' => $data->updater ? $data->updater->only(['id', 'firstNames', 'lastNames', 'displayName']) : null]
        );
    }
}
