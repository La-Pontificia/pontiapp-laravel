@extends('modules.assists.+layout')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;
    $queryTerminals = explode(',', request()->query('assist_terminals'));
    $terminalsInQuery = $queryTerminals ? $terminals->whereIn('id', $queryTerminals) : [];
@endphp

@section('layout.assists')
    <div class="space-y-2 flex flex-col flex-grow">
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
                {{-- <label class="flex p-2 rounded-lg hover:bg-stone-100 items-center gap-2">
                    <input {{ request()->query('force_calculation') ? 'checked' : '' }} type="checkbox"
                        name="force_calculation" value="true">
                    <div>
                        Forzar calculo
                    </div>
                </label> --}}
                <label class="relative w-[200px] max-w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar usuarios..."
                        type="search" class="pl-9 w-full bg-white">
                </label>
                <button type="submit" class="primary mt-2 filter-button">Filtrar</button>
            </form>
            @if (count($assists) !== 0)
                <button type="button" id="button-export-assists-centralized" class="secondary mt-7">
                    @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                    <span>Exportar</span>
                </button>
            @endif
        </div>
        <nav class="flex items-center gap-2 px-2">
            @foreach ($terminalsInQuery as $term)
                <div class="text-sm py-1 px-2 rounded-full bg-orange-500/10 text-orange-500">
                    {{ $term->name }}
                </div>
            @endforeach
        </nav>
        <div class="flex flex-col h-full">
            <div class="h-full overflow-auto">
                @if (count($assists) === 0)
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
                                <th class="text-left">Terminal</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y z-[0]">
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
                                                'src' => $assist['user']->profile,
                                                'className' => 'w-10',
                                                'key' => $assist['user']->id,
                                                'alt' => $assist['user']->names(),
                                                'altClass' => 'text-md',
                                            ])
                                            <div>
                                                <a class="text-nowrap text-blue-500 hover:underline"
                                                    href="/users/{{ $assist['user']->id }}">
                                                    {{ $assist['user']->names() }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-nowrap flex items-center gap-2">
                                            @svg('fluentui-calendar-ltr-20-o', 'w-5 h-5')
                                            {{ \Carbon\Carbon::parse($assist['date'])->isoFormat('DD/MM/YYYY') }}
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
                                            {{ date('h:i A', strtotime($assist['from'])) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="">
                                            {{ date('h:i A', strtotime($assist['to'])) }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-center">
                                            {{ $assist['marked_in'] ? date('h:i A', strtotime($assist['marked_in'])) : '-' }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-center">
                                            {{ $assist['marked_out'] ? date('h:i A', strtotime($assist['marked_out'])) : '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            {{ $assist['owes_time'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="block text-nowrap"> {{ $assist['terminal']->name }} </span>
                                            <p class="flex items-center gap-2">
                                                @svg('fluentui-task-list-square-database-20-o', 'w-5 h-5 opacity-70')
                                                <span class="text-sm text-nowrap font-normal">
                                                    {{ $assist['terminal']->database_name }}
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p
                                            class="{{ $assist['observations'] == 'Tardanza' ? 'text-yellow-600' : ($assist['observations'] == 'Completo' ? 'text-green-500' : '') }}">
                                            @if ($assist['observations'])
                                                {{ $assist['observations'] }}
                                            @else
                                                @svg('fluentui-checkmark-circle-24', 'h-6 w-6 text-green-500')
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer>
                        {!! $assists->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
