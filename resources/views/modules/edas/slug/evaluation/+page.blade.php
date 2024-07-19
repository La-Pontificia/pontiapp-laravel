@extends('modules.edas.slug.+layout')

@section('title', 'Eda: ' . $current_year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@section('layout.edas.slug')

    @php

        // if current user is dev

        // if current user is supervisor
        $isSupervisor = $current_user->id === $user->id_supervisor;

        // if has self qualification
        $hasSelfQualification =
            $current_user->hasPrivilege('edas:evaluations:self-qualify') &&
            !$evaluation->closed &&
            !$evaluation->self_qualification;

        // if has average evaluation
        $hasAverage =
            $current_user->hasPrivilege('average_evaluation') &&
            !$evaluation->closed &&
            $isSupervisor &&
            $evaluation->self_qualification &&
            !$evaluation->average;

        // if has close evaluation
        $hasCloseEvaluation =
            $current_user->hasPrivilege('edas:evaluations:close') &&
            !$evaluation->closed &&
            $evaluation->average &&
            $evaluation->self_qualification &&
            $isSupervisor;
    @endphp
    <div class="h-full flex flex-col mt-3 bg-white overflow-auto rounded-xl">
        <input type="hidden" id="input-hidden-id-evaluation" value="{{ $evaluation->id }}">

        @if ($hasSelfQualification)
            <span id="has-self-quaification"></span>
        @endif

        @if ($hasAverage)
            <span id="has-average"></span>
        @endif

        <div class="flex gap-2 p-1 items-center border-b">
            <div class="flex-grow">
                <button onclick="window.history.back()"
                    class="text-blue-700 hover:bg-indigo-100 font-semibold justify-center min-w-max flex items-center rounded-full p-2 gap-1 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    <span class="max-lg:hidden">Evaluacion N°{{ $evaluation->number }}</span>
                </button>
            </div>
            <button {{ !$hasSelfQualification ? 'disabled' : '' }} id="self-qualification-button"
                class="bg-violet-600 disabled:opacity-30 {{ !$hasSelfQualification ? 'hidden' : '' }} hover:bg-violet-700 text-white font-semibold justify-center min-w-max flex items-center rounded-full p-1.5 gap-1 text-sm px-3">
                Autocalificar
            </button>
            <button {{ !$hasAverage ? 'disabled' : '' }} id="average-button"
                class="bg-green-600 disabled:opacity-30 {{ !$hasAverage ? 'hidden' : '' }} hover:bg-green-700 text-white font-semibold justify-center min-w-max flex items-center rounded-full p-1.5 gap-1 text-sm px-3">
                Calificar
            </button>
            <button {{ !$hasCloseEvaluation ? 'disabled' : '' }} id="close-button"
                class="{{ !$hasCloseEvaluation ? 'hidden' : '' }} bg-red-600 disabled:opacity-30 hover:bg-red-700 text-white font-semibold justify-center min-w-max flex items-center rounded-full p-1.5 gap-1 text-sm px-3">
                Cerrar
            </button>
        </div>
        <div id="panel-goals" class="w-full flex-grow overflow-x-auto">
            <table class="w-full">
                <thead class="border-b">
                    <tr class="[&>th]:p-2 [&>th]:text-nowrap text-left [&>th]:font-semibold text-sm">
                        <th class="text-center">N°</th>
                        <th class="min-w-[200px]">Objetivo</th>
                        <th class="min-w-[300px]">Descripción</th>
                        <th class="min-w-[400px]">Indicadores</th>
                        <th>Porcentaje</th>
                        <th>N. A.</th>
                        <th>Promedio</th>
                        <th class="w-[50px]"></th>
                    </tr>
                </thead>
                <tbody id="table-goals" class="divide-y text-[15px]">

                </tbody>
                <tbody>
                    <tr class="text-sm">
                        <td colspan="5" class="text-lg px-4 font-semibold tracking-tight">Total</td>
                        <td class="px-4">
                            <div
                                class="p-2 w-fit mx-auto rounded-xl border-2 border-violet-500 px-3 bg-violet-100 font-medium">
                                <span id="total-self-qualification">0</span>
                            </div>
                        </td>
                        <td class="px-4">
                            <div
                                class="p-2 w-fit mx-auto rounded-xl border-2 border-green-500 px-3 bg-green-100 font-medium">
                                <span id="total-average">0</span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="border-t p-2 text-sm flex flex-col gap-1">
            @if ($evaluation->self_qualification)
                <p class="text-neutral-400 text-sm">Autocalificado
                    el {{ \Carbon\Carbon::parse($evaluation->self_rated_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $evaluation->selfRatedBy->first_name }} {{ $evaluation->selfRatedBy->last_name }}"
                        href="/profile/{{ $evaluation->selfRatedBy->id }}" class="hover:underline text-blue-600">
                        {{ $evaluation->selfRatedBy->first_name }}
                        {{ $evaluation->selfRatedBy->last_name }}.
                    </a>
                </p>
            @endif

            @if ($evaluation->average)
                <p class="text-neutral-400 text-sm">Calificado
                    el {{ \Carbon\Carbon::parse($evaluation->averaged_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $evaluation->averagedBy->first_name }} {{ $evaluation->averagedBy->last_name }}"
                        href="/profile/{{ $evaluation->averagedBy->id }}" class="hover:underline text-blue-600">
                        {{ $evaluation->averagedBy->first_name }}
                        {{ $evaluation->averagedBy->last_name }}.
                    </a>
                </p>
            @endif
            @if ($evaluation->closed)
                <p class="text-neutral-400 text-sm">Cerrado
                    el {{ \Carbon\Carbon::parse($evaluation->closed_at)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $evaluation->closedBy->first_name }} {{ $evaluation->closedBy->last_name }}"
                        href="/profile/{{ $evaluation->closedBy->id }}" class="hover:underline text-blue-600">
                        {{ $evaluation->closedBy->first_name }}
                        {{ $evaluation->closedBy->last_name }}.
                    </a>
                </p>
            @endif
        </div>
    </div>
@endsection
