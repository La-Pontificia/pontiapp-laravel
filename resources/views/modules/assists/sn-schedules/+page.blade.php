@extends('modules.assists.+layout')

@section('title', 'Asistencias: Sin horario')

@php
    $start = request()->query('start') ? request()->query('start') : null;
    $end = request()->query('end') ? request()->query('end') : null;

    $query = request()->query('query');

    $currentTerminals = request()->query('terminals');
    if (!is_array($currentTerminals)) {
        $currentTerminals = $currentTerminals ? explode(',', $currentTerminals) : [];
    }

    $default_terminal = $currentTerminals ? '' : 'PL-Alameda';
@endphp

@section('layout.assists')
    <p class="pb-2">
        Asistencias sin horario.
    </p>
    <div class="space-y-2 flex flex-col h-full overflow-auto">
        <div class="flex-grow dinamic-form-to-params flex items-center flex-wrap gap-4">
            <form class="dinamic-form-to-params flex p-1 px-2 items-center gap-2 flex-wrap">
                <input type="text" value="{{ $query }}" name="query" placeholder="DNI, Nombres, apellidos...">
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

            {{-- <button {{ count($schedules) === 0 ? 'disabled' : '' }} data-dropdown-toggle="dropdown"
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
                        <thead class="border-b sticky bg-white top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-normal [&>th]:p-2">
                                <th class="tracking-tight">ID Empleado</th>
                                <th class="tracking-tight w-full">Usuario</th>
                                <th class="tracking-tight">Terminal</th>
                                <th>Fecha</th>
                                <th class="text-center bg-yellow-100">Hora</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y z-[0]">
                            @foreach ($assists as $assist)
                                <tr data-dni="{{ $assist->emp_code }}"
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
                                            {{ $assist->punch_time->format('Y-m-d') }}
                                        </p>
                                    </td>
                                    <td class="bg-yellow-100">
                                        <p class="text-nowrap">
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
