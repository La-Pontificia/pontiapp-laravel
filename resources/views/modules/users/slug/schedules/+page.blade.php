@extends('modules.users.slug.+layout')

@section('title', 'Horario: ' . $user->first_name . ', ' . $user->last_name)

@php
    $days = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];
@endphp

@section('layout.users.slug')
    <div class="max-w-7xl grid xl:grid-cols-2 w-full mx-auto gap-3 px-4">
        <div class="w-full border-neutral-200">
            @if (($cuser->has('users:edit') && !$user->isDev()) || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary mb-2">
                    @svg('fluentui-calendar-person-20-o', 'w-5 h-5')
                    <span>Agregar horario</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar horario
                        </header>
                        <form action="/api/schedules/add/{{ $user->id }}" id="form" method="POST"
                            class="p-3 dinamic-form gap-4 overflow-y-auto flex flex-col">
                            @include('modules.users.create.schedule-form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif
            <div class="grid gap-2 w-full">
                @foreach ($schedules as $schedule)
                    @php
                        $from = date('h:i A', strtotime($schedule->from));
                        $to = date('h:i A', strtotime($schedule->to));
                    @endphp
                    <div class="flex schedule-item items-center gap-2 bg-white shadow-sm border p-2 rounded-xl">
                        @svg('fluentui-calendar-ltr-20-o', 'w-6 h-6')
                        <div class="flex-grow">
                            <h2>{{ $from }} - {{ $to }}</h2>
                            <p class="text-sm text-stone-700">
                                @foreach ($days as $key => $day)
                                    @if (in_array($key, $schedule->days))
                                        {{ $day }}
                                        {{ $key < count($schedule->days) ? ',' : '' }}
                                    @endif
                                @endforeach
                            </p>
                            <p>
                                <span
                                    class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-purple-400">
                                    Desde {{ $schedule->start_date }} {{ $schedule->end_date ? 'hasta' : 'en adelante' }}
                                    {{ $schedule->end_date }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                @svg('fluentui-database-window-20', 'w-4 h-4 mr-1')
                                {{ $schedule->terminal->name }}
                            </span>
                        </div>
                        @if (($cuser->has('users:edit') && !$user->isDev()) || $cuser->isDev())
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $schedule->id }}">
                                @svg('fluentui-more-vertical-16-o', 'w-5 h-5')
                            </button>
                            <div id="dropdown-{{ $schedule->id }}" class="dropdown-content hidden">
                                <button data-modal-target="dialog-{{ $schedule->id }}"
                                    data-modal-toggle="dialog-{{ $schedule->id }}"
                                    class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Editar
                                </button>
                                <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el horario?"
                                    data-adescription="Se aliminará completamente el horario y no se podrá recuperar."
                                    data-param="/api/schedules/delete/{{ $schedule->id }}"
                                    class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Eliminar
                                </button>
                                <button data-modal-target="dialog-archived-{{ $schedule->id }}"
                                    data-modal-toggle="dialog-archived-{{ $schedule->id }}"
                                    class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Archivar
                                </button>
                            </div>

                            <div id="dialog-{{ $schedule->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar horario
                                    </header>
                                    <form action="/api/schedules/{{ $schedule->id }}" id="dialog-form-{{ $schedule->id }}"
                                        method="POST" class="dinamic-form body grid gap-4">
                                        @include('modules.users.create.schedule-form', [
                                            'schedule' => $schedule,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $schedule->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-form-{{ $schedule->id }}" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                            <div id="dialog-archived-{{ $schedule->id }}" tabindex="-1" aria-hidden="true"
                                class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        <h1 class="font-semibold pb-2">Archivar horario</h1>
                                        <p class="text-sm">
                                            Este proceso cambiara el rango de fechas del horario y no se podrá visualizar en
                                            ningun lado solo en los reportes de horarios.
                                        </p>
                                    </header>
                                    <form action="/api/schedules/archive/{{ $schedule->id }}"
                                        id="dialog-archived-form-{{ $schedule->id }}" method="POST"
                                        class="dinamic-form body px-3">
                                        <label class="label" class="py-2">
                                            <span>
                                                Fecha de finalización:
                                            </span>
                                            <input type="date" name="end_date" required>
                                        </label>
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-archived-{{ $schedule->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-archived-form-{{ $schedule->id }}" type="submit">
                                            Archivar</button>
                                    </footer>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @if ($schedules->isEmpty())
                <div class="p-2 rounded-lg bg-white shadow-md">
                    <p class="text-center font-semibold text-sm">
                        No se ha asignado ningún horario a este usuario.
                    </p>
                </div>
            @endif
            @if (!$schedules->isEmpty())
                <button data-modal-target="dialog-archived-all" data-modal-toggle="dialog-archived-all"
                    class="secondary mt-5">
                    @svg('fluentui-archive-24', 'w-5 h-5')
                    Archivar todos los horarios actuales
                </button>

                <div id="dialog-archived-all" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            <h1 class="font-semibold pb-2">Archivar todos los horarios actuales</h1>
                            <p class="text-sm">
                                Este proceso cambiara el rango de fechas de todos los horarios actuales y no se podrá
                                visualizar en
                                ningun lado solo en los reportes de horarios.
                            </p>
                        </header>
                        <form action="/api/schedules/archive/all/{{ $user->id }}" id="dialog-dialog-archived-all"
                            method="POST" class="dinamic-form body px-3">
                            <label class="label" class="py-2">
                                <span>
                                    Fecha de finalización:
                                </span>
                                <input type="date" name="end_date" required>
                            </label>
                        </form>
                        <footer>
                            <button data-modal-hide="dialog-archived-all" type="button">Cancelar</button>
                            <button form="dialog-dialog-archived-all" type="submit">
                                Archivar</button>
                        </footer>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
