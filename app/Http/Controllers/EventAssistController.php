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

    public function index(Request $request)
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

        $event_id = $request->get('event');
        $career = $request->get('career');
        $period = $request->get('period');
        $institution = $request->get('institution');

        if ($event_id) $match->where('event_id', $event_id);
        if ($career) $match->where('career', $career);
        if ($period) $match->where('period', $period);
        if ($institution) $match->where('institution', $institution);

        $assists = $match->paginate();

        return view('modules.events.assists.+page', compact('events', 'assists', 'careers', 'periods', 'institutions'));
    }

    public function create(Request $request)
    {
        $mockup = [
            'dni' => '72377688',
            'email' => '72377688@elp.edu.pe',
            'names' => 'Miguel Angel',
            'lastname_1' => 'Gonzales',
            'lastname_2' => 'Quispe',
            'period' => '2024-3',
            'sex' => 'M',
            'institution' => 'Escuela Superior La Pontificia',
            'career' => 'AE - Administración de Empresas',
        ];

        $event = Event::find($request->event_id);
        $query = $request->input('query');
        if (!$event) return response()->json('Evento no encontrado', 404);

        // logic to search the person by api: http://localhost:8000/api/people/74360982
        // $dni = $request->dni;
        // $response = Http::get("http://localhost:8000/api/people/$dni");
        // if ($response->status() != 200) return response()->json('Persona no encontrada', 404);
        // $person = $response->json();
        // if (!$person) return response()->json('Persona no encontrada', 404);

        $person = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Authorization' => 'Bearer univercelFree',
        ])->get("https://apisunat.daustinn.com/queries/dni?number=$query")->json();

        if (!$person['status']) return response()->json('Persona no encontrada', 404);

        $assist = AssistEvent::create([
            'document_id' => $mockup['dni'],
            'first_name' => $person['credentials']['nombres'],
            'first_surname' => $person['credentials']['apellidoPaterno'],
            'second_surname' => $person['credentials']['apellidoMaterno'],
            'career' => $mockup['career'],
            'event_id' => $event->id,
            'institution' => $mockup['institution'],
            'sex' =>  $mockup['sex'],
            'period' => $mockup['period'],
            'email' => $mockup['email'],
        ]);

        $assist['event'] = $event;

        return response()->json($assist);
    }

    public function report(Request $request)
    {
        AssistEventJob::dispatch($request->get('event'), $request->get('career'), $request->get('period'), $request->get('institution'), Auth::id());
        $user = User::find(Auth::id());
        return response()->json('Una vez finalizado el proceso se le notificará al correo electrónico: ' . $user->email . ' O tambien visualizar en la sección de descargas.');
    }
}
