<?php

namespace App\Http\Controllers\Api\Attention;

use App\Http\Controllers\Controller;
use App\Models\AttentionTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttentionTicketController extends Controller
{

    public function all(Request $req)
    {
        $match = AttentionTicket::orderBy('state', 'desc')->orderBy('created_at', 'desc');
        $paginate = $req->query('paginate', 'false');

        $q = $req->query('q');
        $relationship = explode(',', $req->query('relationship', ''));

        if ($q) $match->where('personDocumentId', 'like', "%$q%")
            ->orWhere('personFirstNames', 'like', "%$q%")
            ->orWhere('personLastNames', 'like', "%$q%")
            ->orWhere('personEmail', 'like', "%$q%");

        if (in_array('creator', $relationship)) $match->with('creator');
        if (in_array('service', $relationship)) $match->with('service');
        if (in_array('service.position', $relationship)) $match->with('service.position');
        if (in_array('service.position.business', $relationship)) $match->with('service.position.business');

        $items = $paginate === 'true' ? $match->paginate() : $match->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'attentionServiceId' => 'required|uuid',
            'personDocumentId' => 'required|string',
            'personFirstNames' => 'required|string',
            'personLastNames' => 'required|string',
            'personGender' => 'required|string',
            'personCareer' => 'required|string',
            'personPeriodName' => 'required|string',
            'personEmail' => 'required|email',
        ]);

        $ticket =  new AttentionTicket();

        $ticket->attentionServiceId = $request->attentionServiceId;
        $ticket->personDocumentId = $request->personDocumentId;
        $ticket->personFirstNames = $request->personFirstNames;
        $ticket->personLastNames = $request->personLastNames;
        $ticket->personGender = $request->personGender;
        $ticket->personCareer = $request->personCareer;
        $ticket->personPeriodName = $request->personPeriodName;
        $ticket->personEmail = $request->personEmail;
        $ticket->creatorId = Auth::id();
        $ticket->save();

        return response()->json($ticket, 201);
    }
}
