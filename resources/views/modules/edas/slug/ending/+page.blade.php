@extends('modules.edas.slug.+layout')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $eda->user->first_name . ' ' . $eda->user->last_name)

@section('title_eda', 'Finalización del EDA')

@php
    $hasCloseEda =
        ((($cuser->has('edas:close') && $eda->user->supervisor_id === $cuser->id) || $cuser->has('edas:close-all')) &&
            !$eda->closed) ||
        $cuser->isDev();
@endphp

@section('layout.edas.slug')
    <div class="h-full flex overflow-auto flex-col pt-0">
        <div class="p-10 space-y-3 flex flex-col h-full">
            <h2 class="text-2xl tracking-tight font-medium">Resumen del eda: {{ $current_year->name }}</h2>
            <div id="accordion-open" data-accordion="open" class="flex flex-col h-full">

                {{-- goals --}}
                <h2 id="goals-headding">
                    <button type="button"
                        class="aria-expanded:bg-transparent py-2 group text-neutral-400 aria-expanded:text-black flex items-center gap-3 justify-between w-full"
                        data-accordion-target="#goals-body" aria-expanded="true" aria-controls="goals-body">
                        <span class="flex items-center gap-2">
                            <img src="/pen.png" class="w-5" alt="">
                            Objectivos: {{ count($eda->goals) }}</span>
                        <svg data-accordion-icon
                            class="w-3 text-neutral-400 group-aria-expanded:text-black h-3 rotate-180 shrink-0"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="goals-body" class="p-2 pl-10" aria-labelledby="goals-headding">
                    <p class="opacity-70 pb-2">
                        {{ $eda->user->first_name }} ha cumplido con los siguientes objetivos:
                    </p>
                    <ul class="list-disc list-inside">
                        @foreach ($eda->goals as $goal)
                            <li>{{ $goal->title }} | {{ $goal->percentage }}%</li>
                        @endforeach
                    </ul>
                    <p class="opacity-70 pt-2 border-t mt-2">
                        - Enviados el {{ \Carbon\Carbon::parse($eda->sent)->isoFormat('LL') }} por
                        {{ $eda->createdBy->last_name }},
                        {{ $eda->createdBy->first_name }}
                    </p>
                    <p class="opacity-70 pt-2">
                        - Aprobado el {{ \Carbon\Carbon::parse($eda->approved)->isoFormat('LL') }} por
                        {{ $eda->approvedBy->last_name }},
                        {{ $eda->approvedBy->first_name }}
                    </p>
                </div>

                {{-- evaluations --}}

                <h2 id="evaluations-headding">
                    <button type="button"
                        class="aria-expanded:bg-transparent group py-2 text-neutral-400 aria-expanded:text-black flex items-center gap-3 justify-between w-full"
                        data-accordion-target="#evaluations-body" aria-expanded="true" aria-controls="evaluations-body">
                        <span class="flex items-center gap-2">
                            <img src="/sheet-pen.png" class="w-5" alt="">
                            Evaluaciones: {{ count($evaluations) }}</span>
                        <svg data-accordion-icon
                            class="w-3 h-3 text-neutral-400 group-aria-expanded:text-black rotate-180 shrink-0"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>

                <div id="evaluations-body" class="p-2 pl-10" aria-labelledby="evaluations-headding">
                    <p class="opacity-70 pb-2 ">
                        {{ $eda->user->first_name }} ha sido evaluado en las siguientes evaluaciones:
                    </p>
                    <ul class="list-decimal list-inside">
                        @foreach ($evaluations as $evaluation)
                            <li>
                                Evaluacion N° {{ $evaluation->number }}
                                <ul class="list-disc list-inside ml-5">
                                    <li>
                                        Nota autocalificada: <b>{{ $evaluation->qualification }}</b>
                                    </li>
                                    @if ($evaluation->selfRatedBy)
                                        <li>
                                            Autocalificada por: {{ $evaluation->selfRatedBy->last_name }},
                                            {{ $evaluation->selfRatedBy->first_name }}
                                        </li>
                                    @endif
                                    <li>
                                        Nota evaluada: <b>{{ $evaluation->self_qualification }}</b>
                                    </li>
                                    @if ($evaluation->qualifiedBy)
                                        <li>
                                            Evaluada por: {{ $evaluation->qualifiedBy->last_name }},
                                            {{ $evaluation->qualifiedBy->first_name }}
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>


                {{-- Questionnaire --}}

                <h2 id="questionnaires-headding">
                    <button type="button"
                        class="aria-expanded:bg-transparent group py-2 text-neutral-400 aria-expanded:text-black flex items-center gap-3 justify-between w-full"
                        data-accordion-target="#questionnaires-body" aria-expanded="true"
                        aria-controls="questionnaires-body">
                        <span class="flex items-center gap-2">
                            <img src="/idea.png" class="w-5" alt="">
                            Cuestionarios (Encuesta del EDA)</span>
                        <svg data-accordion-icon
                            class="w-3 h-3 text-neutral-400 group-aria-expanded:text-black rotate-180 shrink-0"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>


                @php
                    $hasSendCollaboratorQuestionnaire = $eda->user->id === $cuser->id || $cuser->isDev();
                    $hasSendSupervisorQuestionnaire = $eda->user->supervisor_id === $cuser->id || $cuser->isDev();
                @endphp

                <div id="questionnaires-body" class="p-2 pl-10" aria-labelledby="questionnaires-headding">

                    <ul class="list-disc list-inside">
                        @if ($eda->collaboratorQuestionnaire)
                            <li>
                                @svg('fluentui-info-20-o', 'w-5 h-5 inline-block')
                                Cuestionario de colaborador enviado el
                                {{ \Carbon\Carbon::parse($eda->collaboratorQuestionnaire->created_at)->isoFormat('LL') }}
                                por
                                {{ $eda->collaboratorQuestionnaire->answeredBy->last_name }},
                                {{ $eda->collaboratorQuestionnaire->answeredBy->first_name }}
                            </li>
                        @endif

                        @if ($eda->supervisorQuestionnaire)
                            <li>
                                @svg('fluentui-info-20-o', 'w-5 h-5 inline-block')
                                Cuestionario de supervisor enviado el
                                {{ \Carbon\Carbon::parse($eda->supervisorQuestionnaire->created_at)->isoFormat('LL') }}
                                por
                                {{ $eda->supervisorQuestionnaire->answeredBy->last_name }},
                                {{ $eda->supervisorQuestionnaire->answeredBy->first_name }}
                            </li>
                        @endif
                    </ul>

                </div>


                {{-- Summary --}}
                @php
                    $totalQualification = number_format($evaluations->sum('qualification') / $evaluations->count(), 2);
                    $totalSelfQualification = number_format(
                        $evaluations->sum('self_qualification') / $evaluations->count(),
                        2,
                    );
                @endphp

                <h2 class="text-2xl tracking-tight font-semibold mt-5">
                    Promedio total
                </h2>
                <div class="pt-5 pl-5">
                    <p>Promedio nota autocalificada: <span
                            class="font-semibold inline-block bg-violet-500 text-white p-0.5 px-2 rounded-md">{{ $totalQualification }}</span>
                    </p>
                    <p>Promedio nota evaluada: <span
                            class="font-semibold inline-block bg-blue-500 text-white p-0.5 px-2 rounded-md">{{ $totalSelfQualification }}</span>
                    </p>
                </div>

                <div class="py-4 mt-auto">
                    @if ($hasCloseEda)
                        <button data-param="/api/edas/{{ $eda->id }}/close" data-id="{{ $eda->id }}"
                            data-atitle="Cerrar EDA"
                            data-adescription="¿Estás seguro de cerrar el EDA de {{ $eda->user->first_name }} {{ $eda->user->last_name }} del año {{ $current_year->name }}?"
                            class="bg-red-600 shadow-sm dinamic-alert shadow-red-500/10 data-[hidden]:hidden font-semibold justify-center hover:bg-red-700 min-w-max flex items-center rounded-full p-1 gap-1 text-white text-sm px-3">
                            @svg('fluentui-checkmark-circle-12', 'w-5 h-5')
                            Cerrar EDA
                        </button>
                    @endif

                    @if ($eda->closed)
                        <p class="text-xs text-neutral-400 mt-2">
                            EDA cerrado el {{ \Carbon\Carbon::parse($eda->closed)->isoFormat('LL') }} por
                            {{ $eda->closedBy->last_name }},
                            {{ $eda->closedBy->first_name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
