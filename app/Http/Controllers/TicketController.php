<?php

namespace App\Http\Controllers;

use App\Events\TicketListUpdated;
use App\Models\BusinessUnit;
use App\Models\Ticket;
use App\Models\TicketBusinessUnit;
use App\Models\TicketModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderByRaw("CASE WHEN state = 'pending' THEN 0 ELSE 1 END")
            ->orderBy('number', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate();

        return View('modules.tickets.+page', compact('tickets'));
    }

    public function screen()
    {
        return View('modules.tickets.screen.+page');
    }

    public function attentions()
    {
        return View('modules.tickets.attentions.+page');
    }

    public function create()
    {
        return View('modules.tickets.create.+page');
    }

    public function createManual()
    {
        $unitBusiness = BusinessUnit::all();
        return View('modules.tickets.create.manual.+page', compact('unitBusiness'));
    }

    public function pdf()
    {
        return View('modules.tickets.pdf');
    }

    public function store(Request $req)
    {
        $req->validate([
            'document-id' => 'required|numeric',
            'paternal-surname' => 'required',
            'maternal-surname' => 'required',
            'names' => 'required',
            'business-unit' => 'required|uuid',
            'affair' => 'required|max:255',
        ]);

        $countTickets = Ticket::count();

        $ticket = Ticket::create([
            'document_id' => $req->input('document-id'),
            'paternal_surname' => $req->input('paternal-surname'),
            'maternal_surname' => $req->input('maternal-surname'),
            'names' => $req->input('names'),
            'business_id' => $req->input('business-unit'),
            'affair' => $req->input('affair'),
            'number' => $countTickets + 1,
            'user_id' => Auth::id(),
        ]);



        event(new TicketListUpdated(Ticket::all()));


        return response()->json('OK', 200);
    }

    public function settings()
    {
        return redirect('/tickets/settings/modules');
    }

    public function settingsModules(Request $req)
    {
        $match = TicketModule::orderBy('number', 'asc');

        if ($req->get('query')) $match->where('name', 'like', '%' . $req->get('query') . '%');
        if ($req->get('business')) $match->where('business_id', $req->get('business'));

        $ticketModules = $match->paginate();
        $businessUnits = TicketBusinessUnit::all();
        return View('modules.tickets.settings.modules.+page', compact('businessUnits', 'ticketModules'));
    }

    public function settingsSubjects()
    {
        return View('modules.tickets.settings.subjects.+page');
    }

    public function settingsBusinessUnits()
    {
        $businessUnits = BusinessUnit::all();
        $ticketBusinessUnits = TicketBusinessUnit::all();
        return View('modules.tickets.settings.business-units.+page', compact('businessUnits', 'ticketBusinessUnits'));
    }

    // api

    public function SettingsBusinessUnitsUpdate(Request $req)
    {

        $businessUnits = $req->input('business_units', []);

        if (count($businessUnits) === 0) {
            return response()->json('Por favor selecciona al menos una unidad de negocio', 404);
        }

        // delete all business units
        TicketBusinessUnit::truncate();

        foreach ($businessUnits as $businessUnit) {
            TicketBusinessUnit::create([
                'business_unit_id' => $businessUnit,
            ]);
        }

        return response()->json('Unidades de negocio actualizadas correctamente.', 200);
    }
}
