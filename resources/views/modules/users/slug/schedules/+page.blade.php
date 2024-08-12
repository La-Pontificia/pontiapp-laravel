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
    <input type="hidden" value="{{ $user->id }}" id="user-id">

    <div class="p-2 h-full w-full max-w-5xl mx-auto flex flex-col flex-grow">

        <div class="py-2 space-y-1 flex flex-col">
            @if ($cuser->has('users:schedules:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary">
                    @svg('bx-plus', 'w-5 h-5')
                    <span>Agregar horario único</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar horario único
                        </header>
                        <form action="/api/schedules/group/{{ $user->id }}/add" id="schedule-form-add" method="POST"
                            class="p-3 dinamic-form gap-4 overflow-y-auto flex flex-col">
                            @include('modules.users.schedules.slug.form', [
                                'user' => $user,
                            ])
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif

            <div id="schedules" class="flex w-full overflow-x-auto pb-5 pt-2 hidden-scroll mt-2 gap-2">
                @forelse ($schedules as $schedule)
                    <div class="relative">
                        @php
                            $from = date('h:i A', strtotime($schedule->from));
                            $to = date('h:i A', strtotime($schedule->to));
                        @endphp
                        <div data-active data-id="{{ $schedule->id }}"
                            class="group cursor-pointer schedule overflow-hidden w-[230px] shadow-md border border-neutral-300 rounded-xl">
                            <div style="background-color: {{ $schedule->background }}"
                                class="block w-1.5 grayscale opacity-30 group-data-[active]:opacity-100 group-data-[active]:grayscale-0 text-transparent">
                            </div>
                            <div class="p-4 space-y-1 h-full flex flex-col flex-grow">
                                <div class="flex items-center">
                                    <p class="font-medium flex-grow overflow-ellipsis text-nowrap tracking-tight">
                                        {{ $schedule->title }}
                                    </p>
                                </div>
                                <p class="text-sm flex items-center gap-1">
                                    @svg('bxs-time-five', 'w-4 h-4 opacity-60')
                                    {{ $from }} - {{ $to }}
                                </p>

                                <p class="text-sm flex items-center gap-1">
                                    @svg('bxs-calendar', 'w-4 h-4 opacity-60')
                                    {{ date('d-m-Y', strtotime($schedule->start_date)) }} -
                                    {{ date('d-m-Y', strtotime($schedule->end_date)) }}
                                </p>
                                <div>
                                    <span class="text-xs font-semibold text-neutral-600">Se repite cada:</span>
                                    <div class="flex gap-1">
                                        @foreach ($days as $day)
                                            @if (in_array($day['key'], $schedule->days))
                                                <span class="text-xs bg-neutral-700 text-white rounded-full p-1 block px-2">
                                                    {{ $day['name'] }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors absolute top-3 right-3"
                            data-dropdown-toggle="dropdown-{{ $schedule->id }}">
                            @svg('bx-dots-vertical-rounded', 'w-4 h-4')
                        </button>

                        <div id="dropdown-{{ $schedule->id }}" class="dropdown-content hidden">
                            @if ($cuser->has('users:schedules:edit') || $cuser->isDev())
                                <button data-modal-target="dialog-{{ $schedule->id }}"
                                    data-modal-toggle="dialog-{{ $schedule->id }}"
                                    class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Editar
                                </button>
                            @endif
                            @if ($cuser->has('users:schedules:delete') || $cuser->isDev())
                                <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el horario?"
                                    data-adescription="Se aliminará completamente el horario y no se podrá recuperar."
                                    data-param="/api/schedules/delete/{{ $schedule->id }}"
                                    class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Eliminar
                                </button>
                            @endif
                            @if ($cuser->has('users:schedules:archive') || $cuser->isDev())
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
                                    <button data-modal-hide="dialog-{{ $schedule->id }}" type="button">Cancelar</button>
                                    <button form="dialog-form-{{ $schedule->id }}" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="p-20 text-center w-full text-neutral-600 text-sm">
                        No hay horarios disponibles.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="p-1 pt-0 flex-grow overflow-y-auto">
            <div
                class="h-full w-full overflow-y-auto relative bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
                <div id="calendar-schedules" class="w-full h-full overflow-y-auto">
                </div>
                <div id="loader" class="absolute grid rounded-xl place-content-center h-full inset-0 bg-white z-10">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="rounded-2xl w-[350px] h-full flex flex-col px-1 overflow-y-auto">
        <h1 class="text-base font-semibold mt-3 px-1">
            Grupo de horario: <span class="text-blue-700">
                {{ $user->groupSchedule ? $user->groupSchedule->name : '' }}</span>
        </h1>
        <div class="mt-2">
            @if ($cuser->has('users:schedules:create') || $cuser->isDev())
                <button type="button" data-modal-target="create-scheldule-modal" data-modal-toggle="create-scheldule-modal"
                    class="bg-blue-700 mb-3 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <span class="max-lg:hidden">Agregar horario único</span>
                </button>
                <div id="create-scheldule-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 overflow-y-auto w-full flex flex-col max-w-xl max-h-full">
                        <div class="relative overflow-y-auto flex flex-col bg-white rounded-2xl shadow">
                            <div class="flex items-center justify-between p-3 border-b rounded-t">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Nuevo horario
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="create-scheldule-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                            @include('components.users.auditory-card')
                            <form action="/api/schedules/group/{{ $user->id }}/add" id="schedule-form-add"
                                method="POST" class="p-3 dinamic-form gap-4 overflow-y-auto flex flex-col">
                                @include('modules.users.schedules.slug.form', [
                                    'user' => $user,
                                ])
                            </form>
                            <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                <button form="schedule-form-add" type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                    Guardar</button>
                                <button id="button-close-scheldule-modal" data-modal-hide="create-scheldule-modal"
                                    type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div id="schedules" class="flex flex-col space-y-4 pr-5 pt-2 overflow-y-auto h-full">
            @if ($schedules->isEmpty())
                <div class="py-10">
                    <p class="text-gray-500 text-center">No hay horarios disponibles</p>
                </div>
            @endif
            @foreach ($schedules as $schedule)
                @php
                    $from = date('h:i A', strtotime($schedule->from));
                    $to = date('h:i A', strtotime($schedule->to));
                    $daysJson = $schedule->days;
                @endphp
                <div class="relative">
                    <div data-active data-id="{{ $schedule->id }}"
                        class="text-black min-h-36 schedule group relative overflow-hidden shadow-sm bg-white hover:shadow-lg cursor-pointer rounded-2xl flex">
                        <div style="background-color: {{ $schedule->background }}"
                            class="block w-1.5 grayscale opacity-30 group-data-[active]:opacity-100 group-data-[active]:grayscale-0 text-transparent">
                        </div>
                        <div class="p-4 space-y-1 h-full flex flex-col flex-grow">
                            <div class="flex items-center">
                                <p class="font-medium flex-grow overflow-ellipsis text-nowrap tracking-tight">
                                    {{ $schedule->title }}
                                </p>
                            </div>
                            <p class="text-sm">
                                {{ $from }} - {{ $to }}
                            </p>
                            <p class="text-sm text-green-800">
                                {{ \Carbon\Carbon::parse($schedule->start_date)->isoFormat('LL') }}
                                - {{ \Carbon\Carbon::parse($schedule->end_date)->isoFormat('LL') }}
                            </p>
                            <div class="flex flex-wrap gap-1 pt-3">
                                @foreach ($days as $day)
                                    @if (in_array($day['key'], $daysJson))
                                        <span style="background-color: {{ $schedule->background }}"
                                            class="text-xs bg-blue-700 text-white rounded-full p-1 block px-2">
                                            {{ $day['name'] }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button class="absolute opacity-60 hover:opacity-100 top-4 right-3"
                        data-dropdown-toggle="dropdown-schelude-{{ $schedule->id }}">
                        <svg width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>
                    @if ($cuser->has('users:schedules:edit') || $cuser->isDev())
                        <div id="dropdown-schelude-{{ $schedule->id }}"
                            class="z-10 hidden bg-white border divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                            <button data-modal-target="edit-scheldule-modal-{{ $schedule->id }}"
                                data-modal-toggle="edit-scheldule-modal-{{ $schedule->id }}"
                                class="p-2 hover:bg-neutral-100 w-full block rounded-md text-left">Editar</button>
                            <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el horario?"
                                data-adescription="Se aliminará completamente el horario y no se podrá recuperar."
                                data-param="/api/schedules/delete/{{ $schedule->id }}"
                                class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md text-red-600 hover:bg-gray-10">
                                Eliminar
                            </button>
                            <button data-alertvariant="warning" data-atitle="¿Estás seguro de archivar el horario?"
                                data-adescription="Este proceso cambiara el rango de fechas del horario y no se podrá visualizar en ningun lado solo en los reportes de horarios."
                                data-param="/api/schedules/archive/{{ $schedule->id }}"
                                class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md text-red-600 hover:bg-gray-10">
                                Archivar
                            </button>
                        </div>
                        <div id="edit-scheldule-modal-{{ $schedule->id }}" data-modal-backdrop="static" tabindex="-1"
                            aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative overflow-y-auto flex flex-col p-4 w-full max-w-xl max-h-full">
                                <div class="relative overflow-y-auto flex flex-col bg-white rounded-2xl shadow">
                                    <div class="flex items-center justify-between p-3 border-b rounded-t">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Editar horario
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                            data-modal-hide="edit-scheldule-modal-{{ $schedule->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                        </button>
                                    </div>
                                    @include('components.users.auditory-card')
                                    <form action="/api/schedules/{{ $schedule->id }}"
                                        id="schedule-form-edit-{{ $schedule->id }}" method="POST"
                                        class="p-3 overflow-y-auto flex flex-col dinamic-form gap-4">
                                        @include('modules.users.schedules.slug.form', [
                                            'schedule' => $schedule,
                                        ])

                                    </form>
                                    <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                        <button form="schedule-form-edit-{{ $schedule->id }}" type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                            Actualizar</button>
                                        <button id="button-close-scheldule-modal"
                                            data-modal-hide="edit-scheldule-modal-{{ $schedule->id }}" type="button"
                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex-grow overflow-y-auto">
        <div class="w-full h-full overflow-y-auto" id="calendar-schedules">
        </div>
    </div> --}}
@endsection
