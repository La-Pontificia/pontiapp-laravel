<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireTemplate;

class QuestionnaireTemplateController extends Controller
{
    public function index()
    {
        $match = QuestionnaireTemplate::orderBy('use_for', 'desc');
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
