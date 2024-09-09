@extends('modules.edas.+layout')

@section('title', 'Crear plantilla')

@section('layout.edas')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">
            <a href="/edas/questionnaire-templates" class="flex items-center gap-2">
                svg'bx-left-arrow-alt', 'w-5 h-5')
                Crear nueva plantilla de cuestionarios.
            </a>
        </h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <form id="template-form" class="flex flex-col px-1 h-full overflow-y-auto w-full" role="form">
                @include('modules.edas.questionnaire-templates.form')
            </form>
            <div class="p-3 px-4 border-t border-neutral-300 flex gap-2">
                <button type="submit" form="template-form" class="primary">
                    Crear plantilla
                </button>
                <a href="/edas/questionnaire-templates" class="secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </div>
@endsection
