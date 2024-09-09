@extends('modules.edas.+layout')

@section('title', 'Crear plantilla')

@section('layout.edas')
    <div class="w-full max-w-2xl mx-auto">
        <div class="border-b pb-1">
            <div class="flex items-center justify-between p-2">
                <button onclick="window.history.back()" class="flex gap-2 items-center text-gray-900 ">
                    @svg('fluentui-arrow-left-20', 'w-5 h-5')
                    Crear nueva plantilla de cuestionarios.
                </button>
            </div>
        </div>
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
