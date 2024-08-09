@extends('modules.edas.slug.+layout')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@php
    $hasPosibleCreate = $cuser->hasPrivilege('create_edas') && $current_year->status;
    $hasClose =
        $cuser->hasPrivilege('edas:close_all') ||
        ($cuser->hasPrivilege('edas:close') && $user->supervisor_id == $cuser->id);
@endphp

@section('layout.edas.slug')
    @if ($eda)
        {{-- @php
            $evaluationUltimate = $evaluations->last();
            $hasCloseEda =
                ($cuser->hasPrivilege('closet_edas') &&
                    $user->supervisor_id == $cuser->id &&
                    $evaluationUltimate->closet) ||
                $evaluationUltimate->closet;
        @endphp --}}

        <div class="h-full flex flex-col space-y-3 justify-center items-center">
            <div class="text-center">
                <h1 class="text-sm font-semibold">Completa todas las tareas asignadas.</h1>
                <p class=" font-normal text-xs">Eda registrada el
                    {{ \Carbon\Carbon::parse($eda->created_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $eda->createdBy->first_name }} {{ $eda->createdBy->last_name }}"
                        href="/profile/{{ $eda->createdBy->id }}" class="hover:underline text-blue-600">
                        {{ $eda->createdBy->first_name }}
                        {{ $eda->createdBy->last_name }}.
                    </a>
                </p>
            </div>
            <div class="flex gap-3 justify-center max-w-5xl flex-wrap [&>a]:max-w-[250px]">
                <a href="/edas/{{ $user->id }}/eda/{{ $current_year->id }}/goals"
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl">
                    <img src="/pen.png" class="w-6 m-3" alt="">
                    <div class="flex-grow">
                        <h2 class="font-semibold text-sm">Objetivos</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">Agrega sus objetivos y envia para su previa
                            aprobación.
                        </p>
                    </div>
                    @if ($eda->approved)
                        <div class="absolute top-2 right-2">
                            @svg('heroicon-s-check-circle', [
                                'class' => 'w-5 h-5 text-blue-700',
                            ])
                        </div>
                    @endif
                </a>

                @foreach ($evaluations as $index => $evaluation)
                    @php
                        $prevEvaluation = $evaluations[$index - 1] ?? (object) ['closed' => true];
                    @endphp
                    <a href="/edas/{{ $user->id }}/eda/{{ $current_year->id }}/evaluation/{{ $evaluation->id }}"
                        class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl {{ $eda->approved || !$prevEvaluation->closed ? '' : 'grayscale opacity-50 pointer-events-none select-none' }}">
                        <img src="/sheet-pen.png" class="w-6 m-3" alt="">
                        <div class="flex-grow text-sm">
                            <h2 class="font-semibold">Evaluacion N° {{ $evaluation->number }}</h2>
                            <p class="opacity-70 text-xs text-ellipsis line-clamp-2">Completa la evaluación asignada.
                            </p>
                        </div>

                        @if ($evaluation->closed)
                            <div class="absolute top-2 right-2">
                                @svg('heroicon-s-check-circle', [
                                    'class' => 'w-5 h-5 text-blue-700',
                                ])
                            </div>
                        @endif
                    </a>
                @endforeach

                {{-- <div class="space-y-2">
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
                        @if ($hasClose && !$eda->closed)
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
                </div> --}}


                @php
                    $lastEvaluation = $evaluations->last();
                @endphp
                <a href="/edas/{{ $user->id }}/eda/{{ $current_year->id }}/ending"
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl {{ $lastEvaluation->closed ? '' : 'grayscale opacity-50 pointer-events-none select-none' }}">
                    <img src="/sheets.png" class="w-6 m-3" alt="">
                    <div class="flex-grow text-sm">
                        <h2 class="font-semibold">Finalización del Eda.</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">
                            Revisa las notas finales y cierra el EDA.
                        </p>
                    </div>

                    @if ($eda->closed)
                        <div class="absolute top-2 right-2">
                            @svg('heroicon-s-check-circle', [
                                'class' => 'w-5 h-5 text-blue-700',
                            ])
                        </div>
                    @endif
                </a>
                <a href="/edas/{{ $user->id }}/eda/{{ $current_year->id }}/questionnaires"
                    class="bg-white border relative hover:shadow-lg shadow-md flex items-center gap-2 p-2 rounded-xl {{ $eda->closed ? '' : 'grayscale opacity-50 pointer-events-none select-none' }}">
                    <img src="/idea.png" class="w-6 m-3" alt="">
                    <div class="flex-grow">
                        <h2 class="font-semibold text-sm">Cuestionarios</h2>
                        <p class="opacity-70 text-xs text-ellipsis line-clamp-2">
                            Responde a los cuestionario asignados por cada Eda. y visualiza los resultados de su
                            Supervisor o colaborador.
                        </p>
                    </div>
                    {{-- @if ($eda->approved)
                        <div class="absolute top-2 right-2">
                            <x-heroicon-s-check-circle class="w-6 h-6 text-blue-700" />
                        </div>
                    @endif --}}
                </a>
            </div>
        </div>
    @endif
@endsection
