<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireTemplate;
use Illuminate\Http\Request;

class QuestionnaireTemplateController extends Controller
{
    public function index(Request $request)
    {
        $for = $request->get('for');

        $match = QuestionnaireTemplate::orderBy('in_use', 'desc');

        if ($for) {
            $match->where('for', $for);
        }

        $templates = $match->paginate();

        return view('modules.edas.questionnaire-templates.+page', [
            'templates' => $templates,
        ]);
    }

    public function create()
    {
        return view('modules.edas.questionnaire-templates.create.+page');
    }

    public function slug($id)
    {
        $template = QuestionnaireTemplate::find($id);

        if (!$template) {
            return view('+404');
        }

        return view('modules.edas.questionnaire-templates.slug.+page', [
            'template' => $template,
        ]);
    }

    public function questions($id)
    {
        $template = QuestionnaireTemplate::findOrFail($id);
        return view('modules.edas.questionnaire-templates.slug.+page', [
            'template' => $template,
        ]);
    }
}
