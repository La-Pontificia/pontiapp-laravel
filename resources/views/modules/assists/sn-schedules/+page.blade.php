@extends('modules.assists.+layout')

@section('title', 'Asistencias: Sin horario')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $query = request()->query('query');

    $currentTerminal = request()->query('terminal') ?? $terminals[0]->database_name;

@endphp

@section('layout.assists')
    <p class="py-2 text-sm">
        Asistencias sin horario. En este modo solo se muestran las marcaciones en las bases de datos de los terminales.
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

            {{-- <button {{ count($schedules) === 0 ? 'disabled' : '' }} data-dropdown-toggle="dropdown"
                class="secondary ml-auto">
                svg'bx-up-arrow-circle', 'w-5 h-5')
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
            </div> --}}
        </div>
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
                            </tr>
                        </thead>
                        <tbody class="divide-y z-[0]">
                            @foreach ($assists as $assist)
                                <tr data-dni="{{ $assist->emp_code }}"
                                    class="[&>td]:py-3 even:bg-neutral-100 [&>td>p]:text-nowrap relative group [&>td]:px-3">
                                    <td>
                                        <div>
                                            <p class="text-nowrap">
                                                {{ $assist->employee->first_name }} {{ $assist->employee->last_name }}
                                            </p>
                                            <p class="text-xs">
                                                {{ $assist->emp_code }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-nowrap flex items-center gap-2">
                                            @svg('fluentui-calendar-ltr-20-o', 'w-5 h-5')
                                            {{ $assist->punch_time->format('Y-m-d') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap capitalize">
                                            {{ $assist->punch_time->isoFormat('dddd') }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ $assist->terminal_alias }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-nowrap text-center">
                                            {{ $assist->punch_time->format('H:i:s') }}
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
