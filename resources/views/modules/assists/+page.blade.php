@extends('modules.assists.+layout')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $currentTerminal = request()->query('terminal');

    $default_terminal = 'PL-Alameda';
@endphp

@section('layout.assists')
    <div class="space-y-2 flex flex-col h-full">
        <div class="flex-grow flex items-center flex-wrap">
            <form class="dinamic-form-to-params p-1 px-2 flex items-end flex-grow gap-2 flex-wrap">
                <label>
                    <span class="block">Area:</span>
                    <select name="area" class="bg-white">
                        <option value>Todas las areas</option>
                        @foreach ($areas as $area)
                            <option {{ request()->query('area') === $area->id ? 'selected' : '' }}
                                value="{{ $area->id }}">
                                {{ $area->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span class="block">Departamento:</span>
                    <select name="department" class="bg-white">
                        <option value>Todos los departamentos</option>
                        @foreach ($departments as $department)
                            <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                                value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </label>

                <div id="date-range" class="flex items-center gap-1">
                    <label for="">
                        <span class="block">Desde:</span>
                        <input class="w-[100px] bg-white" readonly {{ $start ? "data-default=$start" : '' }} type="text"
                            name="start" placeholder="-">
                    </label>
                    <label for="">
                        <span class="block">Hasta:</span>
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
                <label class="relative ml-auto w-[200px] max-w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar usuarios..."
                        type="search" class="pl-9 w-full bg-white">
                </label>
                <button type="submit" class="primary mt-2">Filtrar</button>
            </form>
            @if (count($schedules) !== 0)
                <button type="button" id="export-centralied-assists" data-dropdown-toggle="dropdown"
                    class="secondary mt-7">
                    @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                    Exportar
                </button>
            @endif
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
                    <table class="w-full text-left relative">
                        <thead class="border-b top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                                <th class=" tracking-tight">Usuario</th>
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

                                <tr class="[&>td]:py-2 even:bg-neutral-100 [&>td>p]:text-nowrap relative group [&>td]:px-3">
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @include('commons.avatar', [
                                                'src' => $schedule['user']->profile,
                                                'className' => 'w-10',
                                                'key' => $schedule['user']->id,
                                                'alt' =>
                                                    $schedule['user']->first_name .
                                                    ' ' .
                                                    $schedule['user']->last_name,
                                                'altClass' => 'text-md',
                                            ])
                                            <div>
                                                <p class="">
                                                    {{ $schedule['user']->names() }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-nowrap flex items-center gap-2">
                                            @svg('fluentui-calendar-ltr-20-o', 'w-5 h-5')
                                            {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD/MM/YYYY') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="capitalize ">
                                            {{ $day }}
                                        </p>
                                    </td>
                                    <td>
                                        <p tip="Turno de trabajo: {{ $TTorTM }}"
                                            class="text-center  {{ $TTorTM === 'TM' ? 'text-yellow-500' : 'text-violet-600' }}">
                                            @svg($TTorTM === 'TM' ? 'fluentui-weather-sunny-16' : 'fluentui-weather-moon-16-o', 'w-5 h-5')
                                        </p>
                                    </td>
                                    <td>
                                        <p class="">
                                            {{ date('h:i A', strtotime($schedule['from'])) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="">
                                            {{ date('h:i A', strtotime($schedule['to'])) }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-center">
                                            {{ $schedule['marked_in'] ? date('h:i A', strtotime($schedule['marked_in'])) : '-' }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-center">
                                            {{ $schedule['marked_out'] ? date('h:i A', strtotime($schedule['marked_out'])) : '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            {{ $schedule['owes_time'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="flex items-center gap-1 ">
                                            @if ($schedule['terminal'])
                                                {{ $schedule['terminal'] }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p
                                            class="{{ $schedule['observations'] == 'Tardanza' ? 'text-yellow-600' : ($schedule['observations'] == 'Completo' ? 'text-green-500' : '') }}">
                                            {{ !$isFuture ? $schedule['observations'] : '' }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer>
                        {!! $schedules->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
