@extends('modules.users.slug.+layout')

@section('title', 'Horario: ' . $user->first_name . ', ' . $user->last_name)

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

@section('layout.users.slug')
    <div class="flex max-w-2xl w-full mx-auto items-center gap-3 p-2">
        <div class="border-t pt-2 w-full border-neutral-200">
            <p class="pb-3 text-lg">
                Horarios de {{ $user->names() }}
            </p>
            @if (($cuser->has('schedules:create') && $cuser->id !== $user->id && !$user->isDev()) || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary mb-2">
                    @svg('fluentui-calendar-person-20-o', 'w-5 h-5')
                    <span>Agregar horario único</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar horario único para <b>{{ $user->names() }}</b>
                        </header>
                        <form action="/api/schedules/group/{{ $user->id }}/add" id="form" method="POST"
                            class="p-3 dinamic-form gap-4 overflow-y-auto flex flex-col">
                            @include('modules.schedules.slug.form', [
                                'user' => $user,
                            ])
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
                @foreach ($user->summarySchedules() as $schedule)
                    @php
                        $from = date('h:i A', strtotime($schedule->from));
                        $to = date('h:i A', strtotime($schedule->to));
                    @endphp
                    <div class="flex w-full shadow-md bg-white border p-3 rounded-lg text-sm gap-2 items-center">
                        <div class="flex-grow">
                            <div class="border-b w-full flex items-center gap-2 pb-2">
                                @svg($schedule->user_id ? 'fluentui-calendar-person-20-o' : 'fluentui-calendar-info-20-o', 'w-6 h-6 text-blue-700')
                                <p class="font-semibold">
                                    {{ $schedule->title }}
                                    <span class="opacity-50">
                                        {{ $schedule->user_id ? ' (Personal)' : '' }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex pt-2 items-center gap-2">
                                @svg('fluentui-clock-16-o', 'w-6 h-6 opacity-60')
                                <div class=" flex-grow">
                                    <p class="font-semibold">
                                        {{ $from }} - {{ $to }}
                                    </p>
                                    <div class="flex ">
                                        @foreach ($days as $key => $day)
                                            @if (in_array($day['key'], $schedule->days))
                                                <span class=" text-stone-500">
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
                                @svg('fluentui-more-vertical-16-o', 'w-5 h-5')
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
                                        Editar horario: {{ $schedule->title }} de <b>{{ $user->names() }}</b>
                                    </header>
                                    <form action="/api/schedules/{{ $schedule->id }}" id="dialog-form-{{ $schedule->id }}"
                                        method="POST" class="dinamic-form body grid gap-4">
                                        @include('modules.schedules.slug.form', [
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
            </div>
        </div>
    </div>
@endsection
