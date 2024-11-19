<?php

namespace App\Http\Controllers;

use App\Jobs\AssistEventJob;
use App\Models\AssistEvent;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EventAssistController extends Controller
{

    public function index(Request $req)
    {
        $events = Event::all();
        $match = AssistEvent::orderBy('created_at', 'desc');
        $careers = AssistEvent::select('career')
            ->groupBy('career')
            ->get();
        $periods = AssistEvent::select('period')
            ->groupBy('period')
            ->get();
        $institutions = AssistEvent::select('institution')
            ->groupBy('institution')
            ->get();

        $event_id = $req->get('event');
        $career = $req->get('career');
        $period = $req->get('period');
        $institution = $req->get('institution');

        if ($event_id) $match->where('event_id', $event_id);
        if ($career) $match->where('career', $career);
        if ($period) $match->where('period', $period);
        if ($institution) $match->where('institution', $institution);

        $assists = $match->paginate();

        return view('modules.events.assists.+page', compact('events', 'assists', 'careers', 'periods', 'institutions'));
    }

    public function create(Request $req)
    {

        $query = $req->input('query');
        $institution = $req->input('institution');

        if (!$institution) return response()->json('Institución no encontrada', 404);


        // logic to search the person by api: http://localhost:8000/api/people/74360982
        // $dni = $req->dni;
        // $response = Http::get("http://localhost:8000/api/people/$dni");
        // if ($response->status() != 200) return response()->json('Persona no encontrada', 404);
        // $person = $response->json();
        // if (!$person) return response()->json('Persona no encontrada', 404);

        $event = Event::find($req->input('event'));

        if (!$event) return response()->json('Evento no encontrado', 404);

        $res = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Authorization' => '33yIWUyLZDxOdbdQMMQCZAi28ug',
        ])->get("http://localhost:8001/api/people/$query?institution=$institution");

        if ($res->status() != 200) return response()->json('Persona no encontrada', 404);

        $person = $res->json();
        $assist = AssistEvent::create([
            'document_id' => $person['id'],
            'first_name' => $person['firstName'],
            'first_surname' => $person['lastName'],
            'second_surname' => $person['lastName_2'],
            'career' => $person['career'],
            'event_id' => $event->id,
            'institution' => $institution,
            'sex' =>  $person['sex'],
            'period' => $person['periodName'],
            'email' => $person['email'],
        ]);

        $assist['event'] = $event;

        return response()->json($assist);
    }

    public function report(Request $req)
    {
        AssistEventJob::dispatch($req->get('event'), $req->get('career'), $req->get('period'), $req->get('institution'), Auth::id());
        $user = User::find(Auth::id());
        return response()->json('Una vez finalizado el proceso se le notificará al correo electrónico: ' . $user->email . ' O tambien visualizar en la sección de descargas.');
    }
}
