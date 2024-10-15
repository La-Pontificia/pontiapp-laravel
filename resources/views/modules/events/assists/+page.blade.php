@extends('modules.events.+layout')

@section('title', 'Gestión Eventos')

@php
    $institutionLogos = [
        'ELP' => '/logos/elp.webp',
        'ILP' => 'ilp.webp',
        'Universidad Nacional de San Agustin' => '/logos/elp.webp',
        'Escuela Superior La Pontificia' => '/logos/elp.webp',
        'Instituto La Pontificia' => '/logos/ilp.webp',
    ];

    $institutionNames = [
        'ELP' => 'Escuela Superior La Pontificia',
        'ILP' => 'Instituto La Pontificia',
        'Universidad Nacional de San Agustin' => 'Universidad Nacional de San Agustin',
        'Escuela Superior La Pontificia' => 'Escuela Superior La Pontificia',
        'Instituto La Pontificia' => 'Instituto La Pontificia',
    ];

@endphp

@section('layout.events')
    <div class="w-full mx-auto overflow-y-auto flex flex-col flex-grow">
        <template id="assist_event_row">
            <tr class="[&>td]:p-3 [&>td>p]:line-clamp-1 [&>td]:px-5">
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
            <button data-modal-target="dialog" data-modal-toggle="dialog" class="primary my-2 text-nowrap gradient-btn">
                @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                Registrar asistencia
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo evento
                    </header>
                    <form id="form-search-person" class="body grid gap-4">
                        <div class="py-2">
                            <div class="grid grid-cols-5 gap-2">
                                <label class="label col-span-3">
                                    <span>
                                        DNI
                                    </span>
                                    <input name="query" id="dni" type="text"
                                        class="p-2 text-center font-semibold text-xl" placeholder="72377689">
                                    <p>
                                        Ingrese el DNI para buscar la persona y registrar su asistencia.
                                    </p>
                                </label>
                                <label class="label col-span-2">
                                    <span>Evento</span>
                                    <select name="event_id" class="p-3">
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}">
                                                {{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button" class="w-full">Cerrar</button>
                    </footer>
                </div>
            </div>
            <nav class="flex items-end gap-2">
                <div class="px-1">
                    <div class="flex items-end flex-wrap gap-2">
                        <label class="label col-span-2">
                            <span>Evento</span>
                            <select name="event" class="p-2 dinamic-to-url">
                                <option value>Selecciona un evento</option>
                                @foreach ($events as $event)
                                    <option {{ request()->query('event') === $event->id ? 'selected' : '' }}
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
                                    <option
                                        {{ request()->query('institution') === $institution->institution ? 'selected' : '' }}
                                        value="{{ $institution->institution }}">
                                        {{ $institution->institution }}</option>
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
        <div class="p-2 overflow-y-auto flex flex-col">
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
                            <th class="w-full">
                                Registro
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
                                        {{ $assist->created_at->format('d/m/Y H:i:s') }}
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
        </div>
    </div>
@endsection
