@extends('modules.edas.slug.+layout')

@section('title', 'Objetivos: ' . $year->name . ' - ' . $user->first_name . ' ' . $user->last_name)

@php
    $userIsDev = $cuser->role === 'dev';
    $percentages = range(0, 100);
    $sent = $eda->sent;
    $hasAddGoals = ($cuser->hasPrivilege('edas:goals:send') && !$eda->approved) || $userIsDev;
    $hasSentGoals = ($cuser->hasPrivilege('edas:goals:send') && !$eda->approved) || $userIsDev;
    $hasEditGoals = ($cuser->hasPrivilege('edas:goals:edit') && !$eda->approved) || $userIsDev;
    $hasDeleteGoals = ($cuser->hasPrivilege('edas:goals:delete') && !$eda->approved) || $userIsDev;

    $hasApproveGoals =
        $cuser->hasPrivilege('edas:goals:approve') && !$eda->approved && $user->supervisor_id === $cuser->id;

@endphp

@section('layout.edas.slug')
    <div class="h-full flex overflow-hidden flex-col pt-0 overflow-x-auto">
        @if ($sent)
            <input type="hidden" id="input-hidden-id-eda" value="{{ $eda->id }}">
        @endif

        @if ($hasEditGoals || !$sent)
            <span id="has-edit-goals"></span>
        @endif

        @if ($hasDeleteGoals || !$sent)
            <span id="has-delete-goals"></span>
        @endif

        <div class="flex gap-2 p-1 tracking-tight overflow-auto">
            <div class="flex-grow">
                <button onclick="window.history.back()"
                    class="text-blue-700 hover:bg-indigo-100 font-semibold justify-center min-w-max flex items-center rounded-full p-2 gap-1 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    <span class="max-lg:hidden">Agregar objetivo</span>
                </button>
            </div>
            <button data-id-eda="{{ $eda->id }}" {{ $hasApproveGoals ? '' : 'data-hidden' }} id="approve-goals-button"
                class="bg-blue-600 hover:bg-blue-700 data-[hidden]:hidden text-white font-semibold justify-center min-w-max flex items-center rounded-lg p-2 gap-1 text-sm px-3">
                Aprobar
            </button>
            <button {{ $hasSentGoals ? '' : 'data-hidden' }} disabled data-id-eda="{{ $eda->id }}"
                id="submit-goals-button"
                class="bg-blue-700 data-[hidden]:hidden font-semibold justify-center hover:bg-blue-600 min-w-max flex items-center rounded-lg p-2 gap-1 text-white text-sm px-3">
                {{ $sent ? 'Reenviar' : 'Enviar' }} objetivos
            </button>
        </div>
        <div id="presentation-not-goals" class="p-1 h-full grid place-content-center text-center">
            <div class="max-w-sm mx-auto space-y-2">
                <h1 class="text-black tracking-tight font-semibold text-2xl pt-2">
                    Agrega los objetivos necesarios.
                </h1>
                <p class="pt-2 text-sm">
                    Una vez llegue al 100% de total de porcentaje, podrá enviar los objetivos.
                </p>
                <button class="bg-blue-700 px-3 p-2 rounded-full text-white font-semibold" id="add-goal-button-2">
                    Agregar objetivo
                </button>
            </div>
        </div>
        <div id="panel-goals" class="bg-white rounded-xl w-full hidden flex-grow overflow-auto relative">
            <table class="w-full">
                <thead class="border-b">
                    <tr class="[&>th]:p-2 [&>th]:text-nowrap text-left [&>th]:font-semibold text-sm">
                        <th class="max-w-[50px] w-[50px] text-center">N°</th>
                        <th class="min-w-[200px]">Objetivo</th>
                        <th class="min-w-[300px]">Descripción</th>
                        <th class="min-w-[400px]">Indicadores</th>
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
                <tbody class="bottom-0">
                    <tr class="text-sm">
                        <td colspan="20">
                            <div class="flex justify-center">
                                <button
                                    class="border-blue-700 {{ $hasAddGoals ? '' : 'hidden' }} border-2 flex items-center gap-2 hover:bg-blue-100 px-3 p-2 rounded-full text-blue-700 font-semibold"
                                    id="add-goal-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                        <path d="M5 12h14" />
                                        <path d="M12 5v14" />
                                    </svg>
                                    Agregar objetivo
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-center">
                            <div class="p-2 rounded-full w-fit mx-auto font-semibold text-blue-600">
                                <span id="total-percentage">0</span>%
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-2">
            @if ($eda->sent)
                <p class="text-neutral-400 text-sm">Enviados
                    el {{ \Carbon\Carbon::parse($eda->sent)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $eda->createdBy->first_name }} {{ $eda->createdBy->last_name }}"
                        href="/profile/{{ $eda->createdBy->id }}" class="hover:underline text-blue-600">
                        {{ $eda->createdBy->first_name }}
                        {{ $eda->createdBy->last_name }}.
                    </a>
                </p>
            @endif
            @if ($eda->approved)
                <p class="text-neutral-400 text-sm">Aprobado
                    el {{ \Carbon\Carbon::parse($eda->approved)->isoFormat('LL') }} por
                    <a title="Ir al perfil de {{ $eda->approvedBy->first_name }} {{ $eda->approvedBy->last_name }}"
                        href="/profile/{{ $eda->approvedBy->id }}" class="hover:underline text-blue-600">
                        {{ $eda->approvedBy->first_name }}
                        {{ $eda->approvedBy->last_name }}.
                    </a>
                </p>
            @endif
        </div>
    </div>
@endsection
