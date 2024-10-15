@extends('modules.events.+layout')

@section('title', 'Gestión Eventos')

@php
    $institutionLogos = [
        'elp' => '/logos/elp.webp',
        'ilp' => '/logos/ilp.webp',
    ];

@endphp

@php
    $selectEvent = request()->query('selectEvent');
    $selectInstitution = request()->query('selectInstitution');

    $eventQuery = request()->query('event');
    $institutionQuery = request()->query('institution');

    $institutionsList = [
        'elp' => 'Escuela Superior La Pontificia',
        'ilp' => 'Instituto La Pontificia',
    ];
@endphp

@section('layout.events')
    @if ($selectEvent == 'true')
        <div class="p-10">
            <form class="max-w-xl grid gap-4 mx-auto w-full">
                <h3 class="mb-5 text-xl font-semibold">
                    Selecciona un evento
                </h3>

                <ul>
                    @foreach ($events as $event)
                        <li>
                            <input type="hidden" name="selectInstitution" value="true">
                            <input type="radio" id="r-{{ $event->id }}" name="event" value="{{ $event->id }}"
                                class="hidden peer" required />
                            <label for="r-{{ $event->id }}"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        {{ $event->name }}
                                    </div>
                                    <div class="w-full">
                                        {{ $event->description }}
                                    </div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </label>
                        </li>
                    @endforeach
                </ul>

                <button style="width: 100%; padding: 10px;" class="primary justify-center p-3">
                    Siguiente
                </button>
            </form>
        </div>
    @elseif($selectInstitution == 'true')
        <div class="p-10">
            <form id="nextInstitution" class="max-w-xl grid gap-4 mx-auto w-full">
                <h3 class="mb-5 text-xl font-semibold">
                    Selecciona la institución
                </h3>

                <ul class="flex flex-col gap-2">
                    @foreach ($institutionsList as $key => $institution)
                        <li>
                            <input type="hidden" name="event" value="{{ $eventQuery }}">
                            <input type="radio" id="r-{{ $key }}" name="institution" value="{{ $key }}"
                                class="hidden peer" required />
                            <label for="r-{{ $key }}"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600">
                                <div class="block">
                                    <div class="w-full capitalize text-lg font-semibold">
                                        {{ $key }}
                                    </div>
                                    <div class="w-full">
                                        {{ $institution }}
                                    </div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </label>
                        </li>
                    @endforeach
                </ul>

                <button style="width: 100%; padding: 10px;" class="primary justify-center p-3">
                    Siguiente
                </button>
            </form>
        </div>
    @else
        <div class="w-full mx-auto overflow-y-auto flex flex-col flex-grow">
            <template id="assist_event_row">
                <tr class="[&>td]:p-3 [&>td>p]:text-nowrap [&>td]:px-5">
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                    <td>
                        <p>
                        </p>
                    </td>
                </tr>
            </template>
            <header class="py-2 px-1">
                <nav>
                    <h1 class="font-semibold text-lg">
                        Asistencias a eventos
                    </h1>
                </nav>
                @if ($cuser->has('events:assists:register') || $cuser->isDev())
                    <button data-modal-target="dialog" data-modal-toggle="dialog"
                        class="primary my-2 text-nowrap gradient-btn">
                        @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                        Registrar asistencia
                    </button>
                    <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Registrar nuevo evento
                            </header>
                            <header class="flex justify-center">
                                <img width="100" loading="lazy" decoding="async"
                                    src="{{ $institutionLogos[$institutionQuery] }}" alt="">
                            </header>
                            <form id="form-search-person" class="body grid gap-4">
                                <div class="py-2">
                                    <label class="label">
                                        <span>
                                            DNI
                                        </span>
                                        <input name="query" id="dni" type="text"
                                            class="p-2 text-center font-semibold text-xl" placeholder="72377689">
                                        <p>
                                            Ingrese el DNI para buscar la persona y registrar su asistencia.
                                        </p>
                                    </label>
                                    <input type="hidden" name="event" value="{{ $eventQuery }}">
                                    <input type="hidden" name="institution" value="{{ $institutionQuery }}">
                                </div>
                            </form>
                            <footer>
                                <button data-modal-hide="dialog" type="button" class="w-full">Cerrar</button>
                            </footer>
                        </div>
                    </div>
                @endif
                <nav class="flex items-end gap-2">
                    <div class="px-1">
                        <div class="flex items-end flex-wrap gap-2">
                            <label class="label col-span-2">
                                <span>Evento</span>
                                <select name="event" class="p-2 dinamic-to-url">
                                    <option value>Selecciona un evento</option>
                                    @foreach ($events as $event)
                                        <option {{ $eventQuery === $event->id ? 'selected' : '' }}
                                            value="{{ $event->id }}">
                                            {{ $event->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="label col-span-2">
                                <span>Carrera</span>
                                <select name="career" class="p-2 dinamic-to-url">
                                    <option value>Selecciona una carrera</option>
                                    @foreach ($careers as $career)
                                        <option {{ request()->query('career') === $career->career ? 'selected' : '' }}
                                            value="{{ $career->career }}">
                                            {{ $career->career }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="label col-span-2">
                                <span>Periodo</span>
                                <select name="period" class="p-2 dinamic-to-url">
                                    <option value>Selecciona un periodo</option>
                                    @foreach ($periods as $period)
                                        <option {{ request()->query('period') === $period->period ? 'selected' : '' }}
                                            value="{{ $period->period }}">
                                            {{ $period->period }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="label col-span-2">
                                <span>Institución</span>
                                <select name="institution" class="p-2 dinamic-to-url">
                                    <option value>Selecciona una institución</option>
                                    @foreach ($institutions as $institution)
                                        <option {{ $institutionQuery == $institution->institution ? 'selected' : '' }}
                                            value="{{ $institution->institution }}">
                                            {{ $institutionsList[$institution->institution] }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <button class="primary refresh-page mt-6">
                                Filtrar
                            </button>
                            <button data-url="/api/events/assists/report" class="secondary dinamic-request mt-6">
                                @svg('fluentui-document-arrow-down-16', 'w-5 h-5 opacity-70')
                                Generar reporte
                            </button>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="p-2 overflow-y-auto flex flex-grow flex-col">
                @if ($cuser->has('events:assists:show') || $cuser->isDev())
                    <div class="bg-white overflow-y-auto border border-neutral-200 shadow-md flex-grow rounded-2xl">
                        <table class="w-full">
                            <thead class="border-b">
                                <tr class="[&>th]:font-semibold text-sm [&>th]:p-3 [&>th]:px-5 text-left">
                                    <th>
                                        <div class="flex items-center gap-1">
                                            @svg('fluentui-person-info-20-o', 'w-5 h-5 opacity-70')
                                            Nombres
                                        </div>
                                    </th>
                                    <th>
                                        Correo institucional
                                    </th>
                                    <th>
                                        Carrera
                                    </th>
                                    <th>
                                        Periodo
                                    </th>
                                    <th>
                                        Institución
                                    </th>
                                    <th>
                                        Evento
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th class="w-full">
                                        Hora
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="assist_events" class="divide-y divide-neutral-200/80">
                                @foreach ($assists as $assist)
                                    <tr class="[&>td]:p-3 [&>td>p]:text-nowrap [&>td]:px-5">
                                        <td>
                                            <p>
                                                {{ $assist->first_surname }} {{ $assist->second_surname }},
                                                {{ $assist->first_name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->career }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->period }}
                                            </p>
                                        </td>
                                        <td>
                                            <img width="50" loading="lazy" decoding="async"
                                                src="{{ $institutionLogos[$assist->institution] }}" alt="">
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->event->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->created_at->format('d/m/Y') }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $assist->created_at->format('H:i:s') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <footer>
                            <footer class="px-5 py-4">
                                {!! $assists->links() !!}
                            </footer>
                        </footer>
                    </div>
                @else
                    <div>
                        <p>
                            No tienes permisos para ver esta información.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
