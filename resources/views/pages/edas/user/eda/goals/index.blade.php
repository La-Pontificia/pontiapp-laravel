@extends('layouts.eda-user')

@section('title', 'Objetivos: ' . $year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@php
    $userIsDev = $current_user->role === 'dev';
    $percentages = range(0, 100);
    $sent = $eda->sent;
    $hasAddGoals = ($current_user->hasPrivilege('add_goals') && !$eda->approved) || $userIsDev;
    $hasSentGoals = ($current_user->hasPrivilege('sent_goals') && !$eda->approved) || $userIsDev;
    $hasEditGoals = ($current_user->hasPrivilege('edit_goals') && !$eda->approved) || $userIsDev;
    $hasDeleteGoals = ($current_user->hasPrivilege('delete_goals') && !$eda->approved) || $userIsDev;
    $hasApproveGoals =
        $current_user->hasPrivilege('approve_goals') && $user->id_supervisor === $current_user->id && !$eda->approved;

@endphp

@section('content-eda-user')
    <div class="h-full flex flex-col pt-0 overflow-x-auto">
        @if ($sent)
            <input type="hidden" id="input-hidden-id-eda" value="{{ $eda->id }}">
        @endif

        @if ($hasEditGoals || !$sent)
            <span id="has-edit-goals"></span>
        @endif

        @if ($hasDeleteGoals || !$sent)
            <span id="has-delete-goals"></span>
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
                    <span class="max-lg:hidden">Agregar objetivo</span>
                </button>
            </div>
            <button {{ $hasAddGoals ? '' : 'data-hidden' }} id="add-goal-button"
                class="bg-indigo-100 data-[hidden]:hidden hover:bg-indigo-200 hover:text-indigo-700 text-indigo-600 font-semibold justify-center min-w-max flex items-center rounded-md p-2 gap-1 text-sm px-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span class="max-lg:hidden">Agregar</span>
            </button>
            <button data-id-eda="{{ $eda->id }}" {{ $hasApproveGoals ? '' : 'data-hidden' }} id="approve-goals-button"
                class="bg-indigo-600 hover:bg-indigo-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-md p-2 gap-1 text-sm px-3">
                Aprobar
            </button>
            <button {{ $hasSentGoals ? '' : 'data-hidden' }} disabled data-id-eda="{{ $eda->id }}"
                id="submit-goals-button"
                class="bg-[#5b5fc7] data-[hidden]:hidden font-semibold justify-center hover:bg-[#5053b5] min-w-max flex items-center rounded-md p-2 gap-1 text-white text-sm px-3">
                {{ $sent ? 'Reenviar' : 'Enviar' }} objetivos
            </button>
        </div>
        <div id="presentation-not-goals" class="p-1 h-full grid place-content-center text-center">
            <div class="max-w-sm mx-auto">
                <svg class="text-indigo-500 mx-auto" xmlns="http://www.w3.org/2000/svg" width="40" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-layout-list">
                    <rect width="7" height="7" x="3" y="3" rx="1" />
                    <rect width="7" height="7" x="3" y="14" rx="1" />
                    <path d="M14 4h7" />
                    <path d="M14 9h7" />
                    <path d="M14 15h7" />
                    <path d="M14 20h7" />
                </svg>
                <h1 class="text-indigo-500 text-xl pt-2">
                    Agrega los objetivos necesarios.
                </h1>
                <p class="pt-2 text-sm">
                    Una vez llegue al 100% de total de porcentaje, podrá enviar los objetivos, <button
                        class="text-indigo-500 hover:underline" id="add-goal-button-2">agrega tu primer
                        objetivo.</button>
                </p>
            </div>
        </div>
        <div id="panel-goals" class="py-3 w-full hidden flex-grow overflow-x-auto">
            <table class="w-full">
                <thead class="border-b">
                    <tr class="[&>th]:p-2 [&>th]:text-nowrap text-left [&>th]:font-semibold text-sm">
                        <th>N°</th>
                        <th>Objetivo</th>
                        <th>Descripción</th>
                        <th>Indicadores</th>
                        <th>Porcentaje</th>
                        @if ($sent)
                            <th>Creado por</th>
                            <th>Actualizado por</th>
                        @endif
                        <th class="w-[50px]"></th>
                    </tr>
                </thead>
                <tbody id="table-goals" class="divide-y text-[15px]">

                </tbody>
            </table>
        </div>
        <div class="border-t pt-3 px-3 flex gap-3 items-center">
            <div class="flex-grow">
                @if ($eda->approved)
                    <div class=" text-sm max-w-[40ch]">
                        Objetivos aprobados el
                        {{ \Carbon\Carbon::parse($eda->approved)->isoFormat('LL') }}
                        por <span class="text-indigo-500">{{ $eda->approvedBy->first_name }}
                            {{ $eda->approvedBy->last_name }}</span>
                    </div>
                @endif
            </div>
            <div class="p-2 rounded-lg border border-green-500 px-3 bg-green-100 font-medium">
                Total de porcentaje: <span id="total-percentage">0</span>%
            </div>
        </div>
    </div>
@endsection
