<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $for = $request->get('for');

        $match = Template::orderBy('in_use', 'desc');

        // filters
        if ($for) {
            $match->where('for', $for);
        }

        $templates = $match->paginate();

        return view('pages.templates.index', compact('templates'))
            ->with('i', (request()->input('page', 1) - 1) * $templates->perPage());
    }

    public function create()
    {
        return view('pages.templates.create');
    }

    public function edit($id)
    {
        $template = Template::find($id);
        return view('pages.templates.edit', compact('template'));
    }
}
