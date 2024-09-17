@extends('modules.assists.+layout')

@section('title', 'Asistencias: Resumen único')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;
    $currentTerminal = request()->query('terminal') ?? $terminals[0]->database_name;

@endphp

@section('layout.assists')
    <p class="pb-2">
        Resumen único de fechas
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
                <button type="submit" class="primary mt-2 filter-button">Filtrar</button>
            </form>
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
                        <thead class="border-b sticky top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-semibold [&>th]:p-2 [&>th]:px-3">
                                <th>Fecha</th>
                                <th>
                                    Dia
                                </th>
                                <th class="text-center">Cantidad de asistencias</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y z-[0]">
                            @foreach ($assists as $assist)
                                @php
                                    $date = \Carbon\Carbon::parse($assist['punch_date']);
                                    $day = $date->isoFormat('dddd');
                                @endphp
                                <tr class="[&>td]:p-3">
                                    <td>
                                        {{ $assist['punch_date'] }}
                                    </td>
                                    <td>
                                        <p class="capitalize">
                                            {{ $day }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        {{ $assist['count'] }} asistencias
                                    </td>
                                    <td>
                                        @if ($assist['count'] > 0)
                                            @svg('fluentui-checkmark-circle-24', 'h-6 w-6 text-green-500')
                                        @else
                                            @svg('fluentui-error-circle-12', 'h-6 w-6 text-red-500')
                                        @endif
                                    </td>
                                </tr>
                                {{-- <tr data-dni="{{ $assist->emp_code }}"
                                    class="[&>td]:py-2 even:bg-neutral-100 [&>td>p]:text-nowrap relative group [&>td]:px-3">
                                    <td>
                                        {{ $assist->emp_code }}
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ $assist->employee->first_name }} {{ $assist->employee->last_name }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ $assist->terminal_alias }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-nowrap">
                                            {{ $assist->punch_time->format('d/m/Y') }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-nowrap">
                                            {{ $assist->punch_time->format('H:i:s') }}
                                        </p>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
