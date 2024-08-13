@extends('modules.assists.+layout')

@php
    $start = request()->query('start_date') ? request()->query('start_date') : null;
    $end = request()->query('end_date') ? request()->query('end_date') : null;

    $currentTerminals = request()->query('terminals');
    if (!is_array($currentTerminals)) {
        $currentTerminals = $currentTerminals ? explode(',', $currentTerminals) : [];
    }

    $default_terminal = 'PL-Alameda';
@endphp

@section('layout.assists')
    {{-- <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        <h2 class="py-3 pb-0  tracking-tight text-lg px-2">
            Gestion de asistencias
        </h2>
        <div class="px-1 gap-3 w-full flex items-center">
            <div class="p-1 flex-grow flex items-center gap-2">
                <div class="flex-grow flex items-center flex-wrap gap-2">
                    <div id="date-range" class="flex items-center gap-1 w-[340px]">
                        <input readonly {{ $start ? "data-default=$start" : '' }} type="text" name="start"
                            placeholder="-">
                        <span>a</span>
                        <input readonly {{ $end ? "data-default=$end" : '' }} type="text" name="end" placeholder="-">

                        <button id="filter"
                            class="p-2 rounded-xl bg-green-600 px-2 text-sm text-white shadow-sm ">Filtrar</button>
                    </div>
                    <div>
                        <button type="button" data-modal-target="filters-modal" data-modal-toggle="filters-modal"
                            class=" w-fit bg-white border min-w-max flex items-center rounded-full p-2 gap-1 text-sm px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-list-filter">
                                <path d="M3 6h18" />
                                <path d="M7 12h10" />
                                <path d="M10 18h4" />
                            </svg>
                            <span class="max-lg:hidden">Terminales</span>
                        </button>
                        <div id="filters-modal" data-modal-placement="top-center" tabindex="-1"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative w-full max-w-xl max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <div class="flex items-center justify-between p-2 px-3 border-b rounded-t">
                                        <h3 class="text-xl text-gray-900">
                                            Filtrar resultados de asistencias
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                            data-modal-hide="filters-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <form class="p-3 dinamic-form-acumulate" id="form">
                                        <p class="opacity-70 ">Terminales</p>
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
                                    </form>
                                    <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                        <button type="submit" form="form"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center ">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <select class="dinamic-select" style="border-radius: 50px" name="area">
                            <option value="0">Todas las areas</option>
                            @foreach ($areas as $area)
                                <option {{ request()->query('area') === $area->id ? 'selected' : '' }}
                                    value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="dinamic-select" style="border-radius: 50px" name="department">
                            <option value="0">Todos los departamentos</option>
                            @foreach ($departments as $department)
                                <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                                    value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button {{ count($users) === 0 ? 'disabled' : '' }} id="button-export-assists"
                    class="bg-white hover:shadow-md flex items-center rounded-full gap-2 p-2 text-sm  px-3">
                    <svg width="20" height="20" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                        <g id="SVGRepo_iconCarrier">
                            <defs>
                                <linearGradient id="a" x1="4.494" y1="-2092.086" x2="13.832" y2="-2075.914"
                                    gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#18884f"></stop>
                                    <stop offset="0.5" stop-color="#117e43"></stop>
                                    <stop offset="1" stop-color="#0b6631"></stop>
                                </linearGradient>
                            </defs>
                            <path
                                d="M19.581,15.35,8.512,13.4V27.809A1.192,1.192,0,0,0,9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5Z"
                                style="fill:#185c37"></path>
                            <path d="M19.581,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5L19.581,16l5.861,1.95L30,16V9.5Z"
                                style="fill:#21a366"></path>
                            <path d="M8.512,9.5H19.581V16H8.512Z" style="fill:#107c41"></path>
                            <path
                                d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z"
                                style="opacity:0.10000000149011612;isolation:isolate"></path>
                            <path
                                d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                            <path
                                d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                            <path
                                d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z"
                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                            <path
                                d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z"
                                style="fill:url(#a)"></path>
                            <path
                                d="M5.7,19.873l2.511-3.884-2.3-3.862H7.758L9.013,14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359,3.84,2.419,3.905H10.821l-1.45-2.711A2.355,2.355,0,0,1,9.2,16.8H9.176a1.688,1.688,0,0,1-.168.351L7.515,19.873Z"
                                style="fill:#fff"></path>
                            <path d="M28.806,3H19.581V9.5H30V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#33c481">
                            </path>
                            <path d="M19.581,16H30v6.5H19.581Z" style="fill:#107c41"></path>
                        </g>
                    </svg>
                    <span class="max-lg:hidden">Exportar</span>
                </button>
            </div>
        </div>
        <div class="overflow-auto flex h-full flex-col">
            <div class="h-full shadow-sm rounded-2xl overflow-auto">
                @if (count($schedules) === 0)
                    <div class="grid h-full w-full place-content-center">
                        <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                        <p class="text-center text-xs max-w-[40ch] mx-auto">
                            Seleciona una area o un departamento para ver los registros de asistencias.
                        </p>
                    </div>
                @else
                    <table id="table-export-assists" class="w-full text-left relative">
                        <thead class="border-b sticky bg-[#f1f0f4] top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                                <th class=" tracking-tight">DNI</th>
                                <th class=" tracking-tight">Usuario</th>
                                <th class=" tracking-tight">Título</th>
                                <th>Fecha</th>
                                <th>Dia</th>
                                <th class="text-center">Turno</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Salida</th>
                                <th class="text-center bg-neutral-100">Entró</th>
                                <th class="text-center bg-neutral-100">Salió</th>
                                <th>Diferencia</th>
                                <th class="text-center">Terminal</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y z-[0]">
                            @if (count($schedules) === 0)
                                <tr class="">
                                    <td colspan="11" class="text-center py-4">
                                        <div class="p-10">
                                            No hay registros de asistencias.
                                        </div>
                                    </td>
                                </tr>
                            @else
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
                                        class="[&>td]:py-2 [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl [&>td]:px-3">
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
                                        <td data-value="{{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD-MM-YYYY') }}"
                                            data-name="date">
                                            <p class="text-nowrap flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-calendar opacity-70">
                                                    <path d="M8 2v4" />
                                                    <path d="M16 2v4" />
                                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                                    <path d="M3 10h18" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('LL') }}
                                            </p>
                                        </td>
                                        <td data-value="{{ $day }}" data-name="day">
                                            <p class="capitalize ">
                                                {{ $day }}
                                            </p>
                                        </td>
                                        <td data-value="{{ $TTorTM }}" data-name="turn">
                                            <p
                                                class="text-center  {{ $TTorTM === 'TM' ? 'text-yellow-500' : 'text-violet-500' }}">
                                                {{ $TTorTM }}
                                            </p>
                                        </td>
                                        <td data-value="{{ date('H:i', strtotime($schedule['from'])) }}"
                                            data-name="from">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-smartphone-charging">
                                                        <rect width="14" height="20" x="5" y="2" rx="2"
                                                            ry="2" />
                                                        <path d="M12.667 8 10 12h4l-2.667 4" />
                                                    </svg>
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
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div> --}}
    <p class="pb-2">
        Gestion de asistencia de usuarios.
    </p>
    <div class="space-y-2 flex flex-col h-full">
        <div class="p-1 flex items-end">
            <div class="flex-grow flex items-center flex-wrap gap-4">
                <div id="date-range" class="flex items-center gap-1">
                    <input class="w-[100px]" readonly {{ $start ? "data-default=$start" : '' }} type="text" name="start"
                        placeholder="-">
                    <span>a</span>
                    <input class="w-[100px]" readonly {{ $end ? "data-default=$end" : '' }} type="text" name="end"
                        placeholder="-">
                    <button id="filter"
                        class="p-2 rounded-xl bg-green-600 px-2 text-sm text-white shadow-sm font-semibold">Filtrar</button>
                </div>
                <div class="border-l pl-4 flex items-center gap-3">
                    <select class="dinamic-select" name="area">
                        <option value="0">Todas las areas</option>
                        @foreach ($areas as $area)
                            <option {{ request()->query('area') === $area->id ? 'selected' : '' }}
                                value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>

                    <select class="dinamic-select" name="department">
                        <option value="0">Todos los departamentos</option>
                        @foreach ($departments as $department)
                            <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                                value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>

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
                            <form method="POST" id="form"
                                class="p-3 dinamic-form-acumulate gap-4 overflow-y-auto flex flex-col">
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
                            </form>
                            <footer>
                                <button data-modal-hide="dialog" type="button">Cancelar</button>
                                <button form="form" type="submit" class="primary">Filtrar</button>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
            <button {{ count($schedules) === 0 ? 'disabled' : '' }}}} data-dropdown-toggle="dropdown"
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
            </div>
        </div>
        <div
            class="overflow-auto flex bg-white flex-col border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl h-full">
            <div class="h-full shadow-sm rounded-2xl overflow-auto">
                @if (count($schedules) === 0)
                    <div class="grid h-full w-full place-content-center">
                        <img src="/empty-meetingList.webp" class="mx-auto" alt="">
                        <p class="text-center text-xs max-w-[40ch] mx-auto">
                            No se encontraron asistencias para el rango de fechas seleccionado.
                        </p>
                    </div>
                @else
                    <table id="table-export-assists" class="w-full text-left relative">
                        <thead class="border-b sticky bg-white top-0 z-[1]">
                            <tr class="[&>th]:text-nowrap [&>th]:font-medium [&>th]:p-2">
                                <th class=" tracking-tight">DNI</th>
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
                                    class="[&>td]:py-2 [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl [&>td]:px-3">
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
                                    <td data-value="{{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('DD-MM-YYYY') }}"
                                        data-name="date">
                                        <p class="text-nowrap flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-calendar opacity-70">
                                                <path d="M8 2v4" />
                                                <path d="M16 2v4" />
                                                <rect width="18" height="18" x="3" y="4" rx="2" />
                                                <path d="M3 10h18" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($schedule['date'])->isoFormat('LL') }}
                                        </p>
                                    </td>
                                    <td data-value="{{ $day }}" data-name="day">
                                        <p class="capitalize ">
                                            {{ $day }}
                                        </p>
                                    </td>
                                    <td data-value="{{ $TTorTM }}" data-name="turn">
                                        <p
                                            class="text-center  {{ $TTorTM === 'TM' ? 'text-yellow-500' : 'text-violet-500' }}">
                                            {{ $TTorTM }}
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-smartphone-charging">
                                                    <rect width="14" height="20" x="5" y="2" rx="2"
                                                        ry="2" />
                                                    <path d="M12.667 8 10 12h4l-2.667 4" />
                                                </svg>
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
                @endif
            </div>
        </div>
    </div>
@endsection
