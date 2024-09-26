<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\services\AuditService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $request)
    {

        $query = $request->get('query');

        $match = Event::orderBy('created_at', 'desc');

        if ($query) {
            $match->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
        }

        $events = $match->paginate();
        return view('modules.events.+page', compact('events'))->with('i', (request()->input('page', 1) - 1) * $events->perPage());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => Carbon::parse($validated['start_date']),
            'end_date' => Carbon::parse($validated['end_date']),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        $this->auditService->registerAudit('Evento creado', 'Se ha creado un evento', 'events', 'create', $request);

        return response()->json('Evento creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'start_date' => Carbon::parse($validated['start_date']),
            'end_date' => Carbon::parse($validated['end_date']),
            'updated_by' => auth()->id(),
        ]);

        $this->auditService->registerAudit('Evento actualizado', 'Se ha actualizado un evento', 'events', 'update', $request);

        return response()->json('Evento actualizado correctamente');
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        $this->auditService->registerAudit('Evento eliminado', 'Se ha eliminado un evento', 'events', 'delete', request());

        return response()->json('Evento eliminado correctamente');
    }
}
