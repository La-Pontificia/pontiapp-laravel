@extends('modules.edas.slug.+layout')

@section('title', 'Cuestionario Eda: ' . $current_year->name . ' - ' . $eda->user->first_name . ' ' .
    $eda->user->last_name)

@section('title_eda', 'Cuestionario anual')


@php
    $hasSendCollaboratorQuestionnaire = $eda->user->id === $cuser->id || $cuser->isDev();
    $hasSendSupervisorQuestionnaire = $eda->user->supervisor_id === $cuser->id || $cuser->isDev();
@endphp

@section('layout.edas.slug')
    <div class="h-full p-16 max-xl:px-5 py-4 space-y-3 relative flex flex-col overflow-auto rounded-xl">
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
        <div data-tab-content="collaborators"
            class="w-full data-[hidden]:hidden overflow-y-auto h-full flex-grow flex flex-col">
            @if ($eda->collaboratorQuestionnaire)
                <div class="flex-grow overflow-y-auto">
                    @foreach ($eda->collaboratorQuestionnaire->answers as $index => $answer)
                        <div>
                            <p class="sticky top-0 bg-white pb-2 z-10">
                                <span class="font-semibold opacity-50 inline-block">{{ $index + 1 }}.</span>
                                {{ $answer->question->question }}
                            </p>
                            <div class="pl-5 pb-5">
                                <p class="w-full whitespace-pre-line text-neutral-600 px-4 outline-none border-l min-h-24">
                                    {{ $answer->answer }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs flex items-center pt-2 gap-1 text-wrap text-neutral-400 mt-2">
                    Cuestionario enviada el
                    {{ \Carbon\Carbon::parse($eda->collaboratorQuestionnaire->created_at)->isoFormat('LL') }} por
                    {{ $eda->collaboratorQuestionnaire->answeredBy->last_name }},
                    {{ $eda->collaboratorQuestionnaire->answeredBy->first_name }}
                </p>
            @else
                @isset($collaborator_questionnaire)
                    @if ($hasSendCollaboratorQuestionnaire)
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
                    @else
                        <div class="flex flex-col items-center justify-center h-full">
                            <p class="text-sm font-semibold p-10 text-neutral-600">
                                No puedes responder o no tienes permisos para responder el cuestionario de colaboradores.
                            </p>
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-full">
                        <p class="text-sm font-semibold p-10 text-neutral-600">
                            No hay cuestionario para colaboradores, o no tienes permisos para responderlo.
                        </p>
                    </div>
                @endisset
            @endif
        </div>
        <div data-tab-content="supervisors" data-hidden
            class="w-full data-[hidden]:hidden overflow-y-auto h-full flex-grow flex flex-col">
            @if ($eda->supervisorQuestionnaire)
                <div class="flex-grow overflow-y-auto">
                    @foreach ($eda->supervisorQuestionnaire->answers as $index => $answer)
                        <div>
                            <p class="sticky top-0 bg-white pb-2 z-10">
                                <span class="font-semibold opacity-50 inline-block">{{ $index + 1 }}.</span>
                                {{ $answer->question->question }}
                            </p>
                            <div class="pl-5 pb-5">
                                <p class="w-full text-neutral-600 whitespace-pre-line px-4 outline-none border-l min-h-24">
                                    {{ $answer->answer }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs flex items-center pt-2 gap-1 text-wrap text-neutral-400 mt-2">
                    Cuestionario enviada el
                    {{ \Carbon\Carbon::parse($eda->supervisorQuestionnaire->created_at)->isoFormat('LL') }} por
                    {{ $eda->supervisorQuestionnaire->answeredBy->last_name }},
                    {{ $eda->supervisorQuestionnaire->answeredBy->first_name }}
                </p>
            @else
                @isset($supervisor_questionnaire)
                    @if ($hasSendSupervisorQuestionnaire)
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
                    @else
                        <div class="flex flex-col items-center justify-center h-full">
                            <p class="text-sm font-semibold p-10 text-neutral-600">
                                No puedes responder o no tienes permisos para responder el cuestionario de supervisores.
                            </p>
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center h-full">
                        <p class="text-sm font-semibold p-10 text-neutral-600">
                            No hay cuestionario para supervisores.
                        </p>
                    </div>
                @endisset
            @endif
        </div>
    </div>
@endsection
