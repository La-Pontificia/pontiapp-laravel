<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TicketModule;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function index() {}


    public function settingModule(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'business' => 'nullable|string',
            'number' => 'required|string',
        ]);

        $alreadyExist = TicketModule::where('number', $req->number)
            ->where('business_id', $req->business)
            ->first();

        if ($alreadyExist)
            return response()->json('Ya hay un módulo con el mismo numero y la unidad de negocio', 400);

        $module = new TicketModule();
        $module->name = $req->name;
        $module->business_id = $req->business;
        $module->number = $req->number;
        $module->save();

        return response()->json('Módulo creado correctamente.', 200);
    }

    public function settingModuleUpdate($id, Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'business' => 'nullable|string',
            'number' => 'required|string',
        ]);

        $alreadyExist = TicketModule::where('number', $req->number)
            ->where('business_id', $req->business)
            ->first();

        if ($alreadyExist) {
            if ($alreadyExist->id != $id)
                return response()->json('Ya hay un módulo con el mismo numero y la unidad de negocio', 400);
        }

        $module = TicketModule::find($id);
        $module->name = $req->name;
        $module->business_id = $req->business;
        $module->number = $req->number;
        $module->save();

        return response()->json('Módulo actualizado correctamente.', 200);
    }

    public function settingModuleDelete($id)
    {
        $ticket = TicketModule::find($id);
        $ticket->delete();
        return response()->json('Módulo eliminado correctamente.', 200);
    }


    public function show(string $id) {}


    public function update(Request $req, string $id) {}


    public function destroy(string $id) {}
}
