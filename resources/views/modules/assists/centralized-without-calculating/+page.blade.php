@extends('modules.assists.+layout')

@section('title', 'Asistencias: Sin horario')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $query = request()->query('query');

    $queryTerminals = request()->query('assist_terminals') ? explode(',', request()->query('assist_terminals')) : [];

    $terminalsInQuery = count($queryTerminals) > 0 ? $terminals->whereIn('id', $queryTerminals) : [];

@endphp

@section('layout.assists')
    <p class="py-2 text-sm">
        Asistencias sin horario pero con usario del sistema. En este modo solo se muestran las marcaciones en las bases de
        datos de los terminales y el usuario del sistema.
    </p>
    <div class="space-y-2 flex flex-col h-full overflow-auto">
        <div class="flex-grow flex items-center flex-wrap gap-4">
            <div class="p-1 px-2 flex items-end flex-grow gap-2 flex-wrap">
                <div class="flex items-center gap-1">
                    <label for="">
                        <span class="block">Desde:</span>
                        <input value="{{ $start }}" class="bg-white dinamic-input-to-url" type="date" name="start"
                            placeholder="-">
                    </label>
                    <label for="">
                        <span class="block">Hasta:</span>
                        <input value="{{ $end }}" class="bg-white dinamic-input-to-url" type="date"
                            name="end" placeholder="-">
                    </label>
                </div>
                <label>
                    <span class="block">Area:</span>
                    <select name="area" class="bg-white dinamic-to-url">
                        <option value>-- Todas --</option>
                        @foreach ($areas as $area)
                            <option {{ request()->query('area') === $area->id ? 'selected' : '' }}
                                value="{{ $area->id }}">
                                {{ $area->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span class="block">Departamento:</span>
                    <select name="department" class="bg-white dinamic-to-url">
                        <option value>-- Todos --</option>
                        @foreach ($departments as $department)
                            <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                                value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </label>
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
                                        class="dinamic-checkbox-to-url" value="{{ $terminal->id }}">
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
                <label class="relative w-[200px] max-w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar usuarios..."
                        type="search" class="pl-9 w-full dinamic-input-to-url bg-white">
                </label>
                <button type="submit" class="primary refresh-page mt-2">Filtrar</button>
            </div>
            <button type="button" data-alert="¿Estas seguro(a) de generar el reporte?"
                data-description="Verifica los filtros y rango de fechas antes de ejecutar esta acción."
                data-url="/api/assists/centralized-without-calculating/report" class="secondary dinamic-request mt-6">
                @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                <span>
                    Generar reporte
                </span>
            </button>
        </div>
        <nav class="flex items-center gap-2 px-2">
            @foreach ($terminalsInQuery as $term)
                <div class="text-sm py-1 px-2 rounded-full bg-orange-500/10 text-orange-500">
                    {{ $term->name }}
                </div>
            @endforeach
        </nav>
        <div class="overflow-auto flex flex-col h-full">
            <div class="h-full shadow-sm overflow-auto">
                @if (count($assists) === 0)
                    <div class="grid h-full w-full place-content-center">
                        <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                        <p class="text-center text-xs max-w-[40ch] mx-auto">
                            No se encontraron asistencias. selecciona un rango de fecha o filtros válidos.
                        </p>
                    </div>
                @else
                    <table id="table-export-assists" class="w-full text-left relative">
                        <thead class="border-b top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                                <th class=" tracking-tight">Usuario</th>
                                <th>Fecha</th>
                                <th>Dia</th>
                                <th>Terminal</th>
                                <th class="bg-yellow-100 text-center">Hora</th>
                                <th>Fecha sincronización</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-300 z-[0]">
                            @foreach ($assists as $assist)
                                <tr class="[&>td]:py-3 even:bg-neutral-100 [&>td>p]:text-nowrap relative group [&>td]:px-3">
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
                                            {{ $assist['date'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap capitalize">
                                            {{ $assist['day'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="block"> {{ $assist['terminal']->name }} </span>
                                            <p class="flex items-center gap-2">
                                                @svg('fluentui-task-list-square-database-20-o', 'w-5 h-5 opacity-70')
                                                <span class="text-sm font-normal">
                                                    {{ $assist['terminal']->database_name }}
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-nowrap text-center">
                                            {{ $assist['time'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap flex items-center gap-2">
                                            @svg('fluentui-calendar-sync-20-o', 'w-5 h-5')
                                            {{ $assist['sync_date'] }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 text-center py-6">
                        {{ $total - count($assists) }} asistencias no mostradas
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
