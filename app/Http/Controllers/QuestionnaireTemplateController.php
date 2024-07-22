<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class QuestionnaireTemplateController extends Controller
{
    public function index(Request $request)
    {
        $for = $request->get('for');

        $match = Template::orderBy('in_use', 'desc');

        if ($for) {
            $match->where('for', $for);
        }

        $templates = $match->paginate();

        return view('modules.edas.questionnaires-templates.+page', [
            'templates' => $templates,
        ]);
    }

    public function create()
    {
        return view('modules.edas.questionnaires-templates.create.+page');
    }

    public function questions($id)
    {
        $template = Template::findOrFail($id);
        return view('modules.edas.questionnaires-templates.slug.questions.+page', [
            'template' => $template,
        ]);
    }
}
