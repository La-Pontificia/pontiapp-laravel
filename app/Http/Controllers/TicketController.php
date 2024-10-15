<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return View('modules.tickets.+page');
    }

    public function realTime()
    {
        return View('modules.tickets..real-time.+page');
    }
}
