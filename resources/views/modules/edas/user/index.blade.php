@extends('layouts.eda-user')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@php
    $hasPosibleCreate = ($cuser->has('create_edas') && $current_year->status) || $cuser->isDev();
@endphp

@section('content-eda-user')
    @if ($eda)
        @php
            $evaluationUltimate = $evaluations->last();

            $hasCloseEda =
                ($cuser->has('closed_edas') &&
                    $user->id_supervisor == $current_user->id &&
                    $evaluationUltimate->closed) ||
                ($current_user->hasDevelperPrivilege() && $evaluationUltimate->closed);
        @endphp

        <div class="h-full flex flex-col">
            <div class="py-5 space-y-7 flex flex-col items-start text-left [&>button]:text-left">
                {{-- Goals page --}}
                <div class="space-y-2">
                    <button class="text-lg font-semibold tracking-tight">Objetivos</button>
                    <a href="{{ route('edas.user.goals', ['id_year' => $current_year->id, 'id_user' => $user->id]) }}"
                        class="p-2 gap-2 w-fit items-center shadow-lg shadow-blue-500/30 rounded-2xl bg-white flex bg-gradient-to-br from-blue-700 to-indigo-700 text-white">
                        <div class="p-4 rounded-xl bg-white text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-notebook">
                                <path d="M2 6h4" />
                                <path d="M2 10h4" />
                                <path d="M2 14h4" />
                                <path d="M2 18h4" />
                                <rect width="16" height="20" x="4" y="2" rx="2" />
                                <path d="M16 2v20" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h2 class="font-semibold">Objetivos</h2>
                            <p class="opacity-70 text-sm">Agrega sus objetivos y envia para su previa aprobación.</p>
                        </div>
                        <div class="space-y-1 text-xs flex flex-col items-end">
                            @if ($eda->sent)
                                <span
                                    class="block p-1 px-2 rounded-md bg-green-200 text-green-800 font-semibold">Enviado</span>
                            @endif
                            @if ($eda->approved)
                                <span
                                    class="block p-1 px-2 rounded-md bg-blue-200 text-blue-800 font-semibold">Aprovado</span>
                            @endif
                        </div>
                    </a>
                </div>

                {{-- Evaluations page --}}
                <div class="space-y-2">
                    <button class="text-lg font-semibold tracking-tight">Evaluaciones</button>
                    @if ($eda->approved)
                        @foreach ($evaluations as $index => $evaluation)
                            @php
                                $prevEvaluation = $evaluations[$index - 1] ?? (object) ['closed' => true];
                            @endphp
                            <a href="{{ route('edas.user.evaluation', ['id_year' => $year->id, 'id_user' => $user->id, 'id_evaluation' => $evaluation->id]) }}"
                                {{ !$eda->approved || !$prevEvaluation->closed ? 'data-hidden' : '' }}
                                class="border data-[hidden]:opacity-30 w-fit shadow-md data-[hidden]:pointer-events-none p-2 gap-2 items-center rounded-2xl bg-white hover:border-blue-500 flex">
                                <div class="p-4 text-white rounded-xl bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-select">
                                        <path d="M5 3a2 2 0 0 0-2 2" />
                                        <path d="M19 3a2 2 0 0 1 2 2" />
                                        <path d="M21 19a2 2 0 0 1-2 2" />
                                        <path d="M5 21a2 2 0 0 1-2-2" />
                                        <path d="M9 3h1" />
                                        <path d="M9 21h1" />
                                        <path d="M14 3h1" />
                                        <path d="M14 21h1" />
                                        <path d="M3 9v1" />
                                        <path d="M21 9v1" />
                                        <path d="M3 14v1" />
                                        <path d="M21 14v1" />
                                        <line x1="7" x2="15" y1="8" y2="8" />
                                        <line x1="7" x2="17" y1="12" y2="12" />
                                        <line x1="7" x2="13" y1="16" y2="16" />
                                    </svg>
                                </div>
                                <div class="flex-grow">
                                    <h2 class="font-semibold">Evaluacion N°{{ $evaluation->number }}</h2>
                                    <p class="opacity-70 text-sm text-nowrap">Completa la evaluación asignada.</p>
                                </div>
                                <div class="text-xs flex-wrap justify-end max-w-[200px] flex gap-2 items-end">
                                    @if ($evaluation->self_qualification)
                                        <span
                                            class="block p-1 px-2 rounded-md bg-green-200 text-green-800 font-semibold">Autocalificado</span>
                                    @endif
                                    @if ($evaluation->average)
                                        <span
                                            class="block p-1 px-2 rounded-md bg-blue-200 text-blue-800 font-semibold">Calificado</span>
                                    @endif
                                    @if ($evaluation->closed)
                                        <span
                                            class="block p-1 px-2 rounded-md bg-red-200 text-red-800 font-semibold">Cerrado</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="w-full block opacity-60">
                            Por favor espera a que tus objetivos sean aprobados.
                        </div>
                    @endif
                </div>

                {{-- Finalization page --}}
                <div class="space-y-2">
                    <button class="text-lg font-semibold tracking-tight">Finalización del Eda.</button>
                    @if ($evaluationUltimate->average)
                        @php
                            $totalAverage = $evaluations->sum('average') / $evaluations->count();
                            $totalSelfQualification = $evaluations->sum('self_qualification') / $evaluations->count();
                        @endphp
                        <div class="bg-white rounded-xl w-fit p-3 shadow-md">
                            <span class="text-sm opacity-60">Detalles:</span>
                            <p>Nota autocalificada: <b>{{ $totalSelfQualification }}</b></p>
                            <p>Nota aprobada: <b>{{ $totalAverage }}</b></p>
                        </div>
                        @if ($hasCloseEda && !$eda->closed)
                            <p class="text-rose-500 px-1">
                                El usuario ha terminado las tareas asignadas, por favor revisa y cierra el EDA.
                            </p>
                            <button id="close-eda" data-id="{{ $eda->id }}"
                                class="p-2 px-6 bg-rose-700 hover:bg-rose-600 text-white font-semibold rounded-full">
                                Cerrar EDA
                            </button>
                        @endif
                        @if ($eda->closed)
                            <p class="text-neutral-400 text-sm">Eda cerrado
                                el {{ \Carbon\Carbon::parse($eda->closed)->isoFormat('LL') }} por
                                <a title="Ir al perfil de {{ $eda->closedBy->first_name }} {{ $eda->closedBy->last_name }}"
                                    href="/profile/{{ $eda->closedBy->id }}" class="hover:underline text-blue-600">
                                    {{ $eda->closedBy->first_name }}
                                    {{ $eda->closedBy->last_name }}.
                                </a>
                            </p>
                        @endif
                    @else
                        <div class="w-full block opacity-60">
                            Por favor espera a que las evaluaciones sean cerradas.
                        </div>
                    @endif
                </div>

                {{-- Questionnaires page --}}
                <div class="space-y-2">
                    <button class="text-lg font-semibold tracking-tight">Cuestionarios</button>
                    @if ($eda->closed)
                        <a href="{{ route('edas.user.questionnaires', ['id_year' => $year->id, 'id_user' => $user->id]) }}"
                            class="p-2 gap-2 w-fit items-center shadow-lg shadow-amber-500/30 rounded-2xl bg-white flex bg-gradient-to-br from-amber-700 to-yellow-700 text-white">
                            <div class="p-4 rounded-xl bg-white text-amber-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-book-open">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="font-semibold">Cuestionarios</h2>
                                <p class="opacity-70 text-sm max-w-[40ch]">
                                    Responde a los cuestionario asignados por cada Eda. y visualizar los resultados de su
                                    Supervisor.
                                </p>
                            </div>
                            <div class="space-y-1 text-xs flex flex-col items-end">
                                {{-- @if ($eda->sent)
                                    <span
                                        class="block p-1 px-2 rounded-md bg-green-200 text-green-800 font-semibold">Enviado</span>
                                @endif
                                @if ($eda->approved)
                                    <span
                                        class="block p-1 px-2 rounded-md bg-blue-200 text-blue-800 font-semibold">Aprovado</span>
                                @endif --}}
                            </div>
                        </a>
                    @else
                        <div class="w-full block opacity-60">
                            Por favor espera a que el eda sea Cerrado y calificado
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @endif
@endsection
