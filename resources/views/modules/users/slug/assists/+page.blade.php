@extends('modules.users.slug.+layout')

@section('title', 'Asistencias: ' . $user->first_name . ', ' . $user->last_name)

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $queryTerminals = explode(',', request()->query('assist_terminals'));
    $terminalsInQuery = $queryTerminals ? $terminals->whereIn('id', $queryTerminals) : [];

@endphp

@section('layout.users.slug')
    @if ($cuser->has('assists:show') || $cuser->id === $user->id || $cuser->isDev())
        <div class="space-y-2 flex max-w-2xl mx-auto w-full flex-col h-full">
            <div class="border-t pt-2 w-full border-neutral-200">
                <p class="pb-2 text-lg">
                    Asistencias
                </p>
                <div class="p-1 flex items-end">
                    <form class="flex-grow dinamic-form-to-params flex items-center flex-wrap gap-4">
                        <div class="flex date-range items-center gap-2">
                            <label class="label">
                                <span>Desde</span>
                                <input class="w-[100px] bg-white" readonly type="text" name="start" placeholder="-">
                            </label>
                            <label class="label">
                                <span>Hasta</span>
                                <input class="w-[100px] bg-white" readonly {{ $end ? "data-default=$end" : '' }}
                                    type="text" name="end" placeholder="-">
                            </label>
                        </div>
                        <div class="label">
                            <span>
                                Terminal
                            </span>
                            <button aria-hidden="true" id="terminal_button" data-dropdown-toggle="terminals"
                                class="form-control flex items-center gap-2" type="button">
                                Terminales
                                @svg('fluentui-chevron-down-20-o', 'w-5 h-5')
                            </button>

                            <div id="terminals" class="z-10 hidden w-48 bg-white rounded-lg shadow">
                                <div class="flex flex-col p-1">
                                    @foreach ($terminals as $terminal)
                                        @php
                                            $checked = in_array($terminal->id, $queryTerminals);
                                        @endphp
                                        <label class="flex p-2 rounded-lg hover:bg-stone-100 items-center gap-2">
                                            <input {{ $checked ? 'checked' : '' }} type="checkbox" name="assist_terminals[]"
                                                value="{{ $terminal->id }}">
                                            <div>
                                                <span class="block"> {{ $terminal->name }} </span>
                                                <p class="flex items-center gap-2">
                                                    @svg('fluentui-task-list-square-database-20-o', 'w-5 h-5 opacity-70')
                                                    <span class="text-sm font-normal"> {{ $terminal->database_name }}
                                                    </span>
                                                </p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="primary mt-5">Filtrar</button>
                        @if ($cuser->has('assists:export') || $cuser->isDev())
                            <button data-id="{{ $user->id }}" id="button-export-assists-peer-user" type="button"
                                {{ count($assists) === 0 ? 'disabled' : '' }} class="secondary ml-auto mt-5">
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
                @if (count($assists) === 0)
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
                        @foreach ($assists as $assist)
                            @php
                                $from = \Carbon\Carbon::parse($assist['from']);
                                $date = \Carbon\Carbon::parse($assist['date']);
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
                                            {{ \Carbon\Carbon::parse($assist['date'])->isoFormat('DD/MM/YYYY') }}
                                            •
                                            {{ date('h:i A', strtotime($assist['from'])) }} -
                                            {{ date('h:i A', strtotime($assist['to'])) }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @svg('fluentui-person-clock-20-o', 'w-5 h-5 opacity-70')
                                        <p class="text-nowrap text-blue-600 flex items-center gap-2">
                                            {{ $assist['marked_in'] ? date('h:i A', strtotime($assist['marked_in'])) : '' }}
                                            -
                                            {{ $assist['marked_out'] ? date('h:i A', strtotime($assist['marked_out'])) : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="block"> {{ $assist['terminal']->name }} </span>
                                    <p class="flex items-center gap-2">
                                        @svg('fluentui-task-list-square-database-20-o', 'w-5 h-5 opacity-70')
                                        <span class="text-sm font-normal"> {{ $assist['terminal']->database_name }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <p
                                        class="text-sm {{ $assist['observations'] == 'Tardanza' ? 'text-yellow-600' : ($assist['observations'] == 'Completo' ? 'text-green-500' : '') }}">
                                        {{ !$isFuture ? $assist['observations'] : '' }}
                                    </p>
                                    @if (!$assist['observations'])
                                        @svg('fluentui-checkmark-circle-16', 'w-5 h-5 text-green-600')
                                    @elseif ($assist['observations'] == 'Tardanza')
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
    @else
        <p class="p-20 grid place-content-center text-center">
            No tienes permisos para visualizar estos datos.
        </p>
    @endif
@endsection
