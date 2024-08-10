@extends('modules.edas.slug.+layout')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $eda->user->first_name . ' ' . $eda->user->last_name)

@section('title_eda', 'Finalización del EDA')

@php
    $hasCloseEda =
        (($cuser->has('edas:close') && $eda->user->supervisor_id === $cuser->id) || $cuser->has('edas:close-all')) &&
        !$eda->closed;
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
                <div id="goals-body" class="hidden p-2 pl-10" aria-labelledby="goals-headding">
                    <p class="opacity-70 pb-2">
                        {{ $eda->user->first_name }} ha cumplido con los siguientes objetivos:
                    </p>
                    <ul class="list-disc list-inside">
                        @foreach ($eda->goals as $goal)
                            <li>{{ $goal->title }} | {{ $goal->percentage }}%</li>
                        @endforeach
                    </ul>
                    <p class="opacity-70 pt-2 text-xs border-t mt-2">
                        - Enviados el {{ \Carbon\Carbon::parse($eda->sent)->isoFormat('LL') }} por
                        {{ $eda->createdBy->last_name }},
                        {{ $eda->createdBy->first_name }}
                    </p>
                    <p class="opacity-70 pt-2 text-xs">
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
                <div id="evaluations-body" class="hidden p-2 pl-10" aria-labelledby="evaluations-headding">
                    <p class="opacity-70 pb-2 ">
                        {{ $eda->user->first_name }} ha sido evaluado en las siguientes evaluaciones:
                    </p>
                    <ul class="list-disc list-inside">
                        @foreach ($evaluations as $evaluation)
                            <li>Evaluacion N° {{ $evaluation->number }} | Calificación:
                                <span class="font-medium">{{ $evaluation->qualification }}</span> | Autocalificación:
                                <span class="font-medium">{{ $evaluation->self_qualification }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @php
                    $totalQualification = $evaluations->sum('qualification') / $evaluations->count();
                    $totalSelfQualification = $evaluations->sum('self_qualification') / $evaluations->count();
                @endphp

                <h2 class="text-2xl tracking-tight font-semibold">
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
                        <button data-param="/api/edas/close/{{ $eda->id }}" data-id="{{ $eda->id }}"
                            data-atitle="Cerrar EDA"
                            data-adescription="¿Estás seguro de cerrar el EDA de {{ $eda->user->first_name }} {{ $eda->user->last_name }} del año {{ $current_year->name }}?"
                            class="bg-red-600 shadow-sm dinamic-alert shadow-red-500/10 data-[hidden]:hidden font-semibold justify-center hover:bg-red-700 min-w-max flex items-center rounded-full p-1 gap-1 text-white text-sm px-3">
                            @svg('heroicon-o-x-mark', [
                                'class' => 'w-5 h-5',
                            ])
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
