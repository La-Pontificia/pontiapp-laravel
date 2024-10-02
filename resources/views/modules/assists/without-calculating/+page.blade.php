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
        Asistencias si calcular. En este modo solo se muestran las marcaciones en las bases de datos de los terminales tal y
        como se registraron.
    </p>
    <div class="space-y-2 flex flex-col h-full overflow-auto">
        <div class="flex-grow dinamic-form-to-params flex items-center flex-wrap gap-4">
            <form class="dinamic-form-to-params p-1 px-2 flex items-end flex-grow gap-2 flex-wrap">
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
                <label class="relative ml-auto w-[200px] max-w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar usuarios..."
                        type="search" class="pl-9 w-full bg-white">
                </label>
                <button type="submit" class="primary mt-2 filter-button">Filtrar</button>
            </form>

            {{-- <button {{ $assists->count() === 0 ? 'disabled' : '' }} type="button" id="export-assists-without-calculating"
                class="secondary mt-6">
                @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                <span>
                    Exportar
                </span>
            </button> --}}

            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="secondary mt-6">
                @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                <span>
                    Exportar
                </span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Generar reporte
                    </header>
                    <form action="/api/assists/without-calculating/report" method="POST" id="dialog-form"
                        class="dinamic-form body grid gap-4">
                        <label class="label">
                            <span>
                                Ingresa un correo para notificar cuando el reporte esté listo
                            </span>
                            <input type="email" name="email" placeholder="" required value={{ $cuser->email }}>
                        </label>
                        <p class="text-sm">
                            El reporte se generará con los filtros actuales. y se enviará al correo ingresado o tambien una
                            vez generado puedes descargarlo directamente desde <a href="/reports/downloads"
                                class="text-blue-500 hover:underline" target="_blank">
                                Aquí
                            </a>
                        </p>
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Generar
                        </button>
                    </footer>
                </div>
            </div>

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
                                            <div>
                                                <p>
                                                    {{ $assist['employee_name'] }}
                                                </p>
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
                                                <span class="text-sm font-normal"> {{ $assist['terminal']->database_name }}
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
                    <footer class="px-5 py-4">
                        {!! $assists->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
