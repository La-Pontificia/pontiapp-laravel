@extends('modules.edas.+layout')

@section('title', 'Editar plantilla: ' . $template->name)

@section('layout.edas')

    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">
            <a href="/edas/questionnaire-templates" class="flex items-center gap-2">
                svg'bx-left-arrow-alt', 'w-5 h-5')
                Editar plantilla de cuestionarios: {{ $template->name }}
            </a>
        </h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <form id="template-form" class="flex flex-col px-1 h-full overflow-y-auto w-full" role="form">
                @include('modules.edas.questionnaire-templates.form')
            </form>
            <div class="p-3 px-4 border-t border-neutral-300 flex gap-2">
                <button type="submit" form="template-form" class="primary">
                    Actualizar plantilla
                </button>
                <a href="/edas/questionnaire-templates" class="secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </div>

    {{-- <div class="h-full bg-white relative w-full shadow-md flex flex-col border rounded-xl">
        <nav class="border-b p-1 flex gap-3">
            <button onclick="window.history.back()"
                class="text-blue-500 hover:bg-white font-semibold justify-center min-w-max flex items-center rounded-md p-2 gap-1 text-sm px-2">
                svg'heroicon-o-chevron-left', [
                    'class' => 'w-5 h-5',
                ])
                <span class="max-lg:hidden">Editar plantilla</span>
            </button>
        </nav>
        @include('components.users.auditory-card')
        <form id="template-form" class="flex flex-col px-1 h-full overflow-y-auto w-full" role="form">
            @include('modules.edas.questionnaire-templates.form')
        </form>
        <div class="p-3 px-4 border-t border-neutral-300 flex gap-2">
            <button type="submit" form="template-form"
                class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-1.5 gap-1 text-white text-sm px-3">
                Actualizar
            </button>
            <button onclick="window.history.back()" type="button"
                class="bg-white w-fit font-semibold hover:text-blue-600 text-black min-w-max flex items-center rounded-full p-1.5 gap-1 text-sm px-3">
                Cancelar
            </button>
        </div>
    </div> --}}
@endsection
