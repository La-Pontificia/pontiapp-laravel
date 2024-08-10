@extends('modules.edas.slug.+layout')

@section('title', 'Cuestionario Eda: ' . $current_year->name . ' - ' . $eda->user->first_name . ' ' .
    $eda->user->last_name)

@section('title_eda', 'Cuestionario anual')

@section('layout.edas.slug')

    <div class="h-full p-16 py-4 space-y-3 relative flex flex-col overflow-auto rounded-xl">
        <h2 class="text-2xl tracking-tight font-medium">Cuestionario del eda: {{ $current_year->name }}</h2>
        <div class="border-b flex dinamic-tabs items-center">
            <button data-active data-tab="collaborators"
                class="p-2 px-4 data-[active]:font-semibold data-[active]:border-b border-black">
                Colaboradores
            </button>
            <button data-tab="supervisors" class="p-2 px-4 data-[active]:font-semibold data-[active]:border-b border-black">
                Supervisores
            </button>
        </div>

        @isset($collaborator_questionnaire)
            <div data-tab-content="collaborators"
                class="w-full data-[hidden]:hidden overflow-y-auto h-full flex-grow flex flex-col">
                <div id="questionnaire-collaborator-questions" data-id-eda="{{ $eda->id }}"
                    data-id-questionnaire="{{ $collaborator_questionnaire->id }}"
                    class="py-2 flex-grow space-y-3 hidden-scroll overflow-y-auto">
                    @foreach ($collaborator_questionnaire->questions as $index => $question)
                        <div>
                            <p class="sticky top-0 bg-white pb-2 z-10">
                                <span class="font-semibold opacity-50">{{ $index + 1 }}.</span>
                                {{ $question->question }}
                            </p>
                            <div class="pl-5 pt-3">
                                <div contenteditable="true" data-id-question="{{ $question->id }}"
                                    class="w-full text-neutral-600 px-4 outline-none border-l min-h-24"
                                    aria-placeholder="Respuesta."></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3 pb-1">
                    <button id="questionnaire-collaborator-btn"
                        class="bg-blue-600 p-1.5 px-3 shadow-md shadow-blue-500/20 rounded-xl text-white text-sm">
                        Guardar
                    </button>
                </div>
            </div>
        @endisset
        @isset($supervisor_questionnaire)
            <div data-tab-content="supervisors" data-hidden
                class="w-full data-[hidden]:hidden overflow-y-auto h-full flex-grow flex flex-col">
                <div id="questionnaire-supervisor-questions" data-id-eda="{{ $eda->id }}"
                    data-id-questionnaire="{{ $supervisor_questionnaire->id }}"
                    class="py-2 flex-grow space-y-3 hidden-scroll overflow-y-auto">
                    @foreach ($supervisor_questionnaire->questions as $index => $question)
                        <div>
                            <p class="sticky top-0 bg-white pb-2 z-10">
                                <span class="font-semibold opacity-50">{{ $index + 1 }}.</span>
                                {{ $question->question }}
                            </p>
                            <div class="pl-5 pt-3">
                                <div contenteditable="true" data-id-question="{{ $question->id }}"
                                    class="w-full text-neutral-600 px-4 outline-none border-l min-h-24"
                                    aria-placeholder="Respuesta."></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3 pb-1">
                    <button id="questionnaire-supervisor-btn"
                        class="bg-blue-600 p-1.5 px-3 shadow-md shadow-blue-500/20 rounded-xl text-white text-sm">
                        Guardar
                    </button>
                </div>
            </div>
        @endisset
    </div>
@endsection
