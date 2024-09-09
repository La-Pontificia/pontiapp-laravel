@extends('modules.schedules.+layout')

@section('title', 'Horario ' . $group_schedule->name)

@php
    $days = [
        [
            'name' => 'Lu',
            'value' => 'monday',
            'key' => 1,
            'short' => 'L',
        ],
        [
            'name' => 'Ma',
            'value' => 'tuesday',
            'key' => 2,
            'short' => 'M',
        ],
        [
            'name' => 'Mi',
            'value' => 'wednesday',
            'key' => 3,
            'short' => 'M',
        ],
        [
            'name' => 'Ju',
            'value' => 'thursday',
            'key' => 4,
            'short' => 'J',
        ],
        [
            'name' => 'Vi',
            'value' => 'friday',
            'key' => 5,
            'short' => 'V',
        ],
        [
            'name' => 'Sá',
            'value' => 'saturday',
            'key' => 6,
            'short' => 'S',
        ],
        [
            'name' => 'Do',
            'value' => 'sunday',
            'key' => 7,
            'short' => 'D',
        ],
    ];
@endphp

@section('layout.schedules')
    <div class="p-2 h-full w-full max-w-2xl mx-auto flex flex-col flex-grow">
        {{-- <input type="hidden" id="group-id" value="{{ $group_schedule->id }}"> --}}

        <div class="border-b pb-1">
            <div class="flex items-center justify-between p-2">
                <button onclick="window.history.back()" class="flex gap-2 items-center text-gray-900 ">
                    @svg('fluentui-arrow-left-20', 'w-5 h-5')
                    Horario: {{ $group_schedule->name }}
                </button>
            </div>
        </div>


        <div class="py-2 space-y-1 flex flex-col">
            @if ($cuser->has('schedules:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary">
                    @svg('fluentui-add-circle-16', 'w-5 h-5')
                    <span>Agregar horario</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Nuevo horario
                        </header>
                        <form action="/api/schedules/group/{{ $group_schedule->id }}/add" id="dialog-form" method="POST"
                            class="dinamic-form body grid gap-4">
                            @include('modules.users.schedules.slug.form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif
            <div class="grid gap-2 w-full pt-2">
                @foreach ($schedules as $schedule)
                    @php
                        $from = date('h:i A', strtotime($schedule->from));
                        $to = date('h:i A', strtotime($schedule->to));
                    @endphp
                    <div class="flex w-full shadow-md bg-white border p-3 rounded-lg text-sm gap-2 items-center">
                        <div class="flex-grow">
                            <div class="border-b w-full flex items-center gap-2 pb-2">
                                @svg('fluentui-calendar-info-20-o', 'w-6 h-6 text-blue-700')
                                <p class="font-semibold">
                                    {{ $schedule->title }}
                                </p>
                            </div>
                            <div class="flex pt-2 items-center gap-2">
                                @svg('fluentui-clock-16-o', 'w-6 h-6 opacity-60')
                                <div class="label flex-grow">
                                    <p class="font-semibold">
                                        {{ $from }} - {{ $to }}
                                    </p>
                                    <div class="flex ">
                                        @foreach ($days as $key => $day)
                                            @if (in_array($day['key'], $schedule->days))
                                                <span class="text-xs text-stone-500">
                                                    {{ $day['name'] }}
                                                    {{ $key < count($schedule->days) - 1 ? ',' : '' }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-2">
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $schedule->id }}">
                                @svg('fluentui-more-vertical-16-o', 'w-4 h-4')
                            </button>
                            <div id="dropdown-{{ $schedule->id }}" class="dropdown-content hidden">
                                @if (($cuser->has('schedules:edit') && $schedule->user_id === $cuser->id) || $cuser->isDev())
                                    <button data-modal-target="dialog-{{ $schedule->id }}"
                                        data-modal-toggle="dialog-{{ $schedule->id }}"
                                        class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Editar
                                    </button>
                                @endif
                                @if (($cuser->has('schedules:delete') && $schedule->user_id === $cuser->id) || $cuser->isDev())
                                    <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el horario?"
                                        data-adescription="Se aliminará completamente el horario y no se podrá recuperar."
                                        data-param="/api/schedules/delete/{{ $schedule->id }}"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Eliminar
                                    </button>
                                @endif
                                @if (($cuser->has('schedules:archive') && $schedule->user_id === $cuser->id) || $cuser->isDev())
                                    <button data-alertvariant="warning" data-atitle="¿Estás seguro de archivar el horario?"
                                        data-adescription="Este proceso cambiara el rango de fechas del horario y no se podrá visualizar en ningun lado solo en los reportes de horarios."
                                        data-param="/api/schedules/archive/{{ $schedule->id }}"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Archivar
                                    </button>
                                @endif
                            </div>
                            <div id="dialog-{{ $schedule->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar horario: {{ $schedule->title }}
                                    </header>
                                    <form action="/api/schedules/{{ $schedule->id }}" id="dialog-form-{{ $schedule->id }}"
                                        method="POST" class="dinamic-form body grid gap-4">
                                        @include('modules.users.schedules.slug.form', [
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
                        </div>
                    </div>
                @endforeach
                @if ($schedules->isEmpty())
                    <div class="p-20 text-center">
                        <p>
                            No hay horarios registrados.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
