@extends('modules.users.slug.+layout')

@section('title', 'Asistencias: ' . $user->first_name . ', ' . $user->last_name)

@php

    $start = request()->query('start_date') ? request()->query('start_date') : null;
    $end = request()->query('end_date') ? request()->query('end_date') : null;

    $currentTerminals = request()->query('terminals');
    if (!is_array($currentTerminals)) {
        $currentTerminals = $currentTerminals ? explode(',', $currentTerminals) : [];
    }

    $default_terminal = 'PL-Alameda';

@endphp

@section('layout.users.slug')
    <div class="flex items-center gap-3 font-medium p-2">
        <a href="/users/{{ $user->id }}" class="text-neutral-800 flex p-1 hover:bg-neutral-200 rounded-full">
            @svg('bx-left-arrow-alt', 'w-6 h-6 opacity-70')
        </a>
        Asistencias
    </div>
    <div class="space-y-2 flex flex-col h-full overflow-auto">
        <div class="p-1 flex items-end">
            <div class="flex-grow flex items-center flex-wrap gap-4">
                <div id="date-range" class="flex items-center gap-1">
                    <input class="w-[100px]" readonly {{ $start ? "data-default=$start" : '' }} type="text" name="start"
                        placeholder="-">
                    <span>a</span>
                    <input class="w-[100px]" readonly {{ $end ? "data-default=$end" : '' }} type="text" name="end"
                        placeholder="-">
                    <button id="filter"
                        class="p-2 rounded-xl bg-green-600 px-2 text-sm text-white shadow-sm font-semibold">Filtrar</button>
                </div>
                <div class="border-l pl-4">
                    <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                        class=" w-fit bg-white border font-semibold min-w-max flex items-center rounded-lg p-2 gap-1 text-sm px-3">
                        @svg('bx-devices', 'w-5 h-5')
                        <span class="max-lg:hidden">Terminales</span>
                    </button>

                    <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Filtrar resultados de asistencias por bases de datos y/o terminales.
                            </header>
                            <form method="POST" id="form"
                                class="p-3 dinamic-form-acumulate gap-4 overflow-y-auto flex flex-col">
                                <p class="opacity-70 font-semibold">Terminales</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach ($terminals as $terminal)
                                        <label class="flex items-center gap-1">
                                            <input type="checkbox" class="rounded-lg"
                                                {{ $default_terminal == $terminal->database_name || in_array($terminal->database_name, $currentTerminals) ? 'checked' : '' }}
                                                name="terminals[]" value="{{ $terminal->database_name }}"
                                                class="rounded-lg">
                                            <span>{{ $terminal->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </form>
                            <footer>
                                <button data-modal-hide="dialog" type="button">Cancelar</button>
                                <button form="form" type="submit" class="primary">Filtrar</button>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
            @if ($cuser->has('assists:export') || $cuser->isDev())
                <button {{ count($schedules) === 0 ? 'disabled' : '' }} data-dropdown-toggle="dropdown"
                    class="secondary ml-auto">
                    @svg('bx-up-arrow-circle', 'w-5 h-5')
                    <span>
                        Exportar
                    </span>
                </button>
                <div id="dropdown" class="dropdown-content hidden">
                    <button data-type="excel"
                        class="p-2 hover:bg-neutral-100 button-export-assists text-left w-full block rounded-md hover:bg-gray-10">
                        Excel (.xlsx)
                    </button>
                    <button data-type="json"
                        class="p-2 hover:bg-neutral-100 button-export-assists text-left w-full block rounded-md hover:bg-gray-10">
                        JSON (.json)
                    </button>
                </div>
            @endif
        </div>
        <div class="h-full w-full overflow-auto">
            @if (count($schedules) === 0)
                <div class="grid h-full w-full place-content-center">
                    <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                    <p class="text-center text-xs max-w-[40ch] mx-auto">
                        No se encontraron asistencias para el rango de fechas seleccionado.
                    </p>
                </div>
            @else
                <table id="table-export-assists" class="w-full text-left relative">
                    <thead class="border-b sticky bg-white top-0 z-[1]">
                        <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                            <th class="tracking-tight hidden">DNI</th>
                            <th class="tracking-tight hidden">Usuario</th>
                            <th class="tracking-tight hidden">Título</th>
                            <th>Fecha</th>
                            <th class="hidden">Dia</th>
                            <th class="text-center hidden">Turno</th>
                            <th class="text-center">Entrada</th>
                            <th class="text-center">Salida</th>
                            <th class="text-center bg-yellow-100">Entró</th>
                            <th class="text-center bg-yellow-100">Salió</th>
                            <th>Diferencia</th>
                            <th class="text-center hidden">Terminal</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y z-[0]">
                        @php
                            $currentWeek = null;
                        @endphp
                        @foreach ($schedules as $schedule)
                            @php
                                $from = \Carbon\Carbon::parse($schedule['from']);
                                $date = \Carbon\Carbon::parse($schedule['date']);
                                $weekNumber = $date->weekOfYear;

                                $TTorTM = $from->hour >= 12 ? 'TT' : 'TM';

                                $isFuture = $date->isFuture();
                            @endphp

                            @if ($currentWeek !== null && $currentWeek !== $weekNumber)
                                <tr class="h-8" aria-hidden="true">
                                    <td colspan="11"></td>
                                </tr>
                            @endif

                            @php
                                $currentWeek = $weekNumber;
                            @endphp

                            <tr data-dni="{{ $schedule['dni'] }}" data-fullnames ="{{ $schedule['full_name'] }}"
                                class="[&>td]:py-2 [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl [&>td]:px-3">
                                <td class="hidden">

                                </td>
                                <td class="hidden">

                                </td>
                                <td class="hidden" data-value="{{ $schedule['title'] }}" data-name="title">

                                </td>
                                <td data-value="{{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD-MM-YYYY') }}"
                                    data-name="date">
                                    <p class="text-nowrap flex items-center gap-2">
                                        @svg('bx-calendar', 'w-4 h-4 opacity-60')
                                        {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD-MM-YYYY') }}
                                    </p>
                                </td>
                                <td class="hidden" data-value="{{ $schedule['day'] }}" data-name="day">

                                </td>
                                <td class="hidden" data-value="{{ $TTorTM }}" data-name="turn">

                                </td>
                                <td data-value="{{ date('H:i', strtotime($schedule['from'])) }}" data-name="from">
                                    <p class="">
                                        {{ date('h:i A', strtotime($schedule['from'])) }}
                                    </p>
                                </td>
                                <td data-value="{{ date('H:i', strtotime($schedule['to'])) }}" data-name="to">
                                    <p class="">
                                        {{ date('h:i A', strtotime($schedule['to'])) }}
                                    </p>
                                </td>
                                <td class="bg-yellow-100"
                                    data-value="{{ $schedule['marked_in'] ? date('H:i', strtotime($schedule['marked_in'])) : '-' }}"
                                    data-name="marked_in">
                                    <p class="text-center">
                                        {{ $schedule['marked_in'] ? date('h:i A', strtotime($schedule['marked_in'])) : '-' }}
                                    </p>
                                </td>
                                <td class="bg-yellow-100"
                                    data-value="{{ $schedule['marked_out'] ? date('H:i', strtotime($schedule['marked_out'])) : '-' }}"
                                    data-name="marked_out">
                                    <p class="text-center">
                                        {{ $schedule['marked_out'] ? date('h:i A', strtotime($schedule['marked_out'])) : '-' }}
                                    </p>
                                </td>
                                <td data-value="{{ $schedule['owes_time'] }}" data-name="difference">
                                    <p>
                                        {{ $schedule['owes_time'] }}
                                    </p>
                                </td>
                                <td class="hidden" data-value="{{ $schedule['terminal'] }}" data-name="terminal">

                                </td>
                                <td data-value="{{ $schedule['observations'] }}" data-name="observations">
                                    <p
                                        class="{{ $schedule['observations'] == 'Tardanza' ? 'text-yellow-600' : ($schedule['observations'] == 'Completo' ? 'text-green-500' : '') }}">
                                        {{ !$isFuture ? $schedule['observations'] : '' }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
