@extends('layouts.eda')

@section('title', 'Eda: ' . $year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@section('content-eda')

    @php

        // if current user is dev
        $cuIsDev = $current_user->role === 'dev';

        // if current user is supervisor
        $isSupervisor = $current_user->id === $user->id_supervisor;

        // if has self qualification
        $hasSelfQualification =
            ($current_user->hasPrivilege('self_qualify') && !$evaluation->closed && !$evaluation->self_qualification) ||
            $cuIsDev;

        // if has average evaluation
        $hasAverage =
            ($current_user->hasPrivilege('average_evaluation') &&
                !$evaluation->closed &&
                $isSupervisor &&
                $evaluation->self_qualification &&
                !$evaluation->average) ||
            $cuIsDev;

        // if has close evaluation
        $hasCloseEvaluation =
            ($current_user->hasPrivilege('close_evaluation') &&
                !$evaluation->closed &&
                $evaluation->average &&
                $evaluation->self_qualification &&
                $isSupervisor) ||
            $cuIsDev;
    @endphp
    <div class="h-full flex flex-col pt-0 overflow-x-auto">
        <input type="hidden" id="input-hidden-id-evaluation" value="{{ $evaluation->id }}">

        @if ($hasSelfQualification)
            <span id="has-self-quaification"></span>
        @endif

        @if ($hasAverage)
            <span id="has-average"></span>
        @endif

        <div class="flex gap-2 pb-2 border-b">
            <div class="flex-grow">
                <button onclick="window.history.back()"
                    class="text-[#5b5fc7] hover:bg-indigo-100 font-semibold justify-center min-w-max flex items-center rounded-md p-2 gap-1 text-sm px-2">
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
                class="bg-violet-600 disabled:opacity-30 hover:bg-violet-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-lg p-2 gap-1 text-sm px-3">
                Autocalificar
            </button>
            <button {{ !$hasAverage ? 'disabled' : '' }} id="average-button"
                class="bg-green-600 disabled:opacity-30 hover:bg-green-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-lg p-2 gap-1 text-sm px-3">
                Calificar
            </button>
            <button {{ !$hasCloseEvaluation ? 'disabled' : '' }} id="close-button"
                class="bg-red-600 disabled:opacity-30 hover:bg-red-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-lg p-2 gap-1 text-sm px-3">
                Cerrar
            </button>
        </div>
        <div id="panel-goals" class="py-3 w-full flex-grow overflow-x-auto">
            <table class="w-full">
                <thead class="border-b">
                    <tr class="[&>th]:p-2 [&>th]:text-nowrap text-left [&>th]:font-semibold text-sm">
                        <th>N°</th>
                        <th class="min-w-[200px]">Objetivo</th>
                        <th>Descripción</th>
                        <th>Indicadores</th>
                        <th>Porcentaje</th>
                        <th>N. A.</th>
                        <th>Promedio</th>
                        <th class="w-[50px]"></th>
                    </tr>
                </thead>
                <tbody id="table-goals" class="divide-y text-[15px]">

                </tbody>
            </table>
        </div>
        <div class="border-t pt-3 text-sm px-3 flex gap-3 items-center">
            <div class="flex-grow">
                @if ($evaluation->closed)
                    <div class=" text-sm max-w-[40ch]">
                        Evaluacion cerrada el
                        {{ \Carbon\Carbon::parse($evaluation->closed)->isoFormat('LL') }}
                        por el usuario <span class="text-indigo-500">{{ $evaluation->closedBy->first_name }}
                            {{ $evaluation->closedBy->last_name }}</span>
                    </div>
                @endif
            </div>
            Total N.A. :
            <div class="p-2 rounded-lg border border-violet-500 px-3 bg-violet-100 font-medium">
                <span id="total-self-qualification">0</span>
            </div>
            Total promedio:
            <div class="p-2 rounded-lg border border-green-500 px-3 bg-green-100 font-medium">
                <span id="total-average">0</span>
            </div>
        </div>
    </div>
@endsection
