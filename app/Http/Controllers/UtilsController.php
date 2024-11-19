<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UtilsController extends Controller
{
    public function person($document_id)
    {
        $response = Http::get("https://");
        if ($response->status() != 200) return response()->json('Persona no encontrada', 404);
        $person = $response->json();
        if (!$person) return response()->json('Persona no encontrada', 404);

        return response()->json($person);

        // $res = Http::withOptions([
        //     'verify' => false,
        // ])->withHeaders([
        //     'Authorization' => '33yIWUyLZDxOdbdQMMQCZAi28ug',
        // ])->get("http://localhost:8001/api/people/$query?institution=$institution");

    }
}
