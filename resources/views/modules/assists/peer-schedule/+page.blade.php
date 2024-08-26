@extends('modules.assists.+layout')

@section('title', 'Asistencias: Con horario')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;
    $group = request()->query('group');
    $query = request()->query('query');

    $currentTerminals = request()->query('terminals');
    if (!is_array($currentTerminals)) {
        $currentTerminals = $currentTerminals ? explode(',', $currentTerminals) : [];
    }

    $default_terminal = $currentTerminals ? '' : 'PL-Alameda';
@endphp

@section('layout.assists')
    <p class="pb-2">
        Asistencias con horario.
    </p>
    <div class="space-y-2 flex flex-col h-full overflow-auto">
        <div class="flex-grow dinamic-form-to-params flex items-center flex-wrap gap-4">
            <form class="dinamic-form-to-params flex p-1 px-2 items-center gap-2 flex-wrap">
                <input type="text" value="{{ $query }}" name="query" placeholder="DNI, Nombres, apellidos...">
                <select name="group">
                    <option value>Seleciona un grupo de horario</option>
                    @foreach ($groups as $g)
                        <option {{ $group === $g->id ? 'selected' : '' }} value="{{ $g->id }}">
                            {{ $g->name }}</option>
                    @endforeach
                </select>
                <div id="date-range" class="flex items-center gap-1">
                    <input class="w-[100px]" readonly {{ $start ? "data-default=$start" : '' }} type="text"
                        name="start" placeholder="-">
                    <span>a</span>
                    <input class="w-[100px]" readonly {{ $end ? "data-default=$end" : '' }} type="text" name="end"
                        placeholder="-">
                </div>
                <div class="border-l pl-4 flex items-center gap-3">
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
                            <div class="p-3 gap-4 overflow-y-auto flex flex-col">
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
                                </dov>
                                <footer>
                                    <button data-modal-hide="dialog" type="button" class="primary">Aceptar</button>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="p-2 rounded-xl bg-green-600 px-2 text-sm text-white shadow-sm font-semibold">Filtrar</button>
            </form>
            {{-- <button {{ count($schedules) === 0 ? 'disabled' : '' }} id="button-export-assists-per-schedule"
                class="secondary ml-auto">
                @svg('bx-up-arrow-circle', 'w-5 h-5')
                <span>
                    Exportar Excel
                </span>
            </button> --}}

            <button {{ count($schedules) == 0 ? 'disabled' : '' }} data-modal-target="dialog-export"
                data-modal-toggle="dialog-export" class="secondary ml-auto">
                @svg('bx-up-arrow-circle', 'w-5 h-5')
                <span>Exportar</span>
            </button>
            <div id="dialog-export" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-md max-w-full">
                    <header>
                        Exportar asistencias
                    </header>
                    <form method="POST" class="body grid gap-4">
                        <div class="grid grid-cols-3 gap-4">
                            <label class="flex items-center gap-1">
                                <input type="radio" checked name="type" value="basic">
                                <span>
                                    Básico
                                </span>
                            </label>
                            <label class="flex items-center gap-1">
                                <input disabled type="radio" name="type" value="advanced">
                                <span>
                                    Avanzado
                                </span>
                            </label>
                        </div>
                    </form>
                    <footer>
                        <button data-modal-hide="dialog-export" type="button">Cancelar</button>
                        <button id="button-export-assists-per-schedule" type="button" class="flex items-center gap-1">
                            @svg('bxs-file-doc', 'w-5 h-5')
                            <span>Exportar (.xlsx)</span>
                        </button>
                    </footer>
                </div>
            </div>

        </div>
        <div class="overflow-auto flex flex-col h-full">
            <div class="h-full shadow-sm rounded-2xl overflow-auto">
                @if (count($schedules) === 0)
                    <div class="grid h-full w-full place-content-center">
                        <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                        <p class="text-center text-xs max-w-[40ch] mx-auto">
                            No se encontraron horarios y asistencias. por favor seleccione un area o departamento.
                        </p>
                    </div>
                @else
                    <header class="px-5 py-4">
                        {!! $schedules->links() !!}
                    </header>
                    <table id="table-export-assists" class="w-full text-left relative">
                        <thead class="border-b sticky bg-white top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                                <th class=" tracking-tight">DNI/ID</th>
                                <th class=" tracking-tight">Usuario</th>
                                <th class=" tracking-tight">Título</th>
                                <th>Fecha</th>
                                <th>Dia</th>
                                <th class="text-center">Turno</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Salida</th>
                                <th class="text-center bg-yellow-100">Entró</th>
                                <th class="text-center bg-yellow-100">Salió</th>
                                <th>Diferencia</th>
                                <th class="text-center">Terminal</th>
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
                                    $day = $date->isoFormat('dddd');

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
                                    class="[&>td]:py-2 even:bg-neutral-100 [&>td>p]:text-nowrap relative group [&>td]:px-3">
                                    <td>
                                        <p class="">
                                            {{ $schedule['dni'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="">
                                            {{ $schedule['full_name'] }}
                                        </p>
                                    </td>
                                    <td data-value="{{ $schedule['title'] }}" data-name="title">
                                        <p class="text-nowrap">
                                            {{ $schedule['title'] }}
                                        </p>
                                    </td>
                                    <td data-value="{{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD/MM/YYYY') }}"
                                        data-name="date">
                                        <p class="text-nowrap flex items-center gap-2">
                                            {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD/MM/YYYY') }}
                                        </p>
                                    </td>
                                    <td data-value="{{ $day }}" data-name="day">
                                        <p class="capitalize ">
                                            {{ $day }}
                                        </p>
                                    </td>
                                    <td data-value="{{ $TTorTM }}" data-name="turn">
                                        <p tip="Turno de trabajo: {{ $TTorTM }}"
                                            class="text-center  {{ $TTorTM === 'TM' ? 'text-yellow-500' : 'text-violet-600' }}">
                                            @svg($TTorTM === 'TM' ? 'bxs-sun' : 'bxs-moon', 'w-4 h-4')
                                        </p>
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
                                    <td data-value="{{ $schedule['terminal'] }}" data-name="terminal">
                                        <p class="flex items-center gap-1 ">
                                            @if ($schedule['terminal'])
                                                {{ $schedule['terminal'] }}
                                            @endif
                                        </p>
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
                    <footer class="px-5 py-4">
                        {!! $schedules->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
