@extends('modules.users.slug.+layout')

@section('title', 'Asistencias: ' . $user->first_name . ', ' . $user->last_name)

@php

    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $currentTerminal = request()->query('terminal');

    $default_terminal = 'PL-Alameda';

@endphp

@section('layout.users.slug')
    <div class="space-y-2 flex max-w-2xl mx-auto w-full flex-col h-full">
        <div class="border-t pt-2 w-full border-neutral-200">
            <p class="pb-2 text-lg">
                Asistencias
            </p>
            <div class="p-1 flex items-end">
                <form class="flex-grow dinamic-form-to-params flex items-center flex-wrap gap-4">
                    <div id="date-range" class="flex items-center gap-2">
                        <label class="label">
                            <span>Desde</span>
                            <input class="w-[100px] bg-white" readonly type="text" name="start" placeholder="-">
                        </label>
                        <label class="label">
                            <span>Hasta</span>
                            <input class="w-[100px] bg-white" readonly {{ $end ? "data-default=$end" : '' }} type="text"
                                name="end" placeholder="-">
                        </label>
                    </div>
                    <div class="label">
                        <span>
                            Terminal
                        </span>
                        <select name="terminal" class="bg-white">
                            @foreach ($terminals as $terminal)
                                <option value="{{ $terminal->database_name }}"
                                    {{ $currentTerminal === $terminal->database_name ? 'selected' : '' }}>
                                    {{ $terminal->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="primary mt-5">Filtrar</button>
                    @if ($cuser->has('assists:export') || $cuser->isDev())
                        <button data-id="{{ $user->id }}" id="button-export-assists-peer-user" type="button"
                            {{ count($schedules) === 0 ? 'disabled' : '' }} class="secondary ml-auto mt-5">
                            @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                            <span>
                                Exportar
                            </span>
                        </button>
                    @endif
                </form>
            </div>
        </div>
        <div class="h-full w-full">
            @if (count($schedules) === 0)
                <div class="grid h-full w-full place-content-center">
                    <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                    <p class="text-center text-xs max-w-[40ch] mx-auto">
                        No se encontraron asistencias para el rango de fechas seleccionado.
                    </p>
                </div>
            @else
                <div class="space-y-2">
                    @php
                        $currentWeek = null;
                    @endphp
                    @foreach ($schedules as $schedule)
                        @php
                            $from = \Carbon\Carbon::parse($schedule['from']);
                            $date = \Carbon\Carbon::parse($schedule['date']);
                            $weekNumber = $date->weekOfYear;

                            $TTorTM = $from->hour >= 12 ? 'TT' : 'TM';
                            $day = $date->isoFormat('dddd');

                            $isFuture = $date->isFuture();
                        @endphp

                        @if ($currentWeek !== null && $currentWeek !== $weekNumber)
                            <div class="h-8">
                            </div>
                        @endif

                        @php
                            $currentWeek = $weekNumber;
                        @endphp

                        <div class="p-2.5 bg-white/40 rounded-lg flex shadow-md items-center gap-5">
                            <div class="space-y-2 flex-grow">
                                <div class="flex items-center gap-2">
                                    @svg('fluentui-calendar-rtl-20-o', 'w-5 h-5 opacity-70')
                                    <p class="text-nowrap flex items-center gap-2">
                                        {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD/MM/YYYY') }}
                                        •
                                        {{ date('h:i A', strtotime($schedule['from'])) }} -
                                        {{ date('h:i A', strtotime($schedule['to'])) }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @svg('fluentui-person-clock-20-o', 'w-5 h-5 opacity-70')
                                    <p class="text-nowrap text-blue-600 flex items-center gap-2">
                                        {{ $schedule['marked_in'] ? date('h:i A', strtotime($schedule['marked_in'])) : '' }}
                                        -
                                        {{ $schedule['marked_out'] ? date('h:i A', strtotime($schedule['marked_out'])) : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <p
                                    class="text-sm {{ $schedule['observations'] == 'Tardanza' ? 'text-yellow-600' : ($schedule['observations'] == 'Completo' ? 'text-green-500' : '') }}">
                                    {{ !$isFuture ? $schedule['observations'] : '' }}
                                </p>
                                @if (!$schedule['observations'])
                                    @svg('fluentui-checkmark-circle-16', 'w-5 h-5 text-green-600')
                                @elseif ($schedule['observations'] == 'Tardanza')
                                    @svg('fluentui-warning-16-o', 'w-5 h-5 text-yellow-600')
                                @else
                                    @svg('fluentui-important-12-o', 'w-5 h-5 text-red-600')
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
