@extends('modules.users.+layout')

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

@section('layout.users')
    <div class="p-2 flex h-full flex-grow">
        <div class="max-w-xs h-full max-lg:max-w-full w-full flex flex-col overflow-y-auto">
            <input type="hidden" id="group-id" value="{{ $group_schedule->id }}">
            <button onclick="window.history.back()" class="bg-white p-2 rounded-xl w-fit flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Volver atras
            </button>
            <h1 class="text-base font-semibold mt-3 px-1">
                Grupo de horario: <span class="text-blue-700"> {{ $group_schedule->name }}</span>
            </h1>
            <div class="py-2 px-1 space-y-2">
                @if ($current_user->hasPrivilege('users:schedules:create'))
                    <button type="button" data-modal-target="create-scheldule-modal"
                        data-modal-toggle="create-scheldule-modal"
                        class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-plus">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        <span class="max-lg:hidden">Agregar horario</span>
                    </button>
                    <div id="create-scheldule-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative overflow-y-auto flex flex-col p-4 w-full max-w-xl max-h-full">
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
                                <form action="/api/schedules/group/{{ $group_schedule->id }}/add" id="schedule-form-add"
                                    method="POST" class="p-3 overflow-y-auto flex flex-col dinamic-form gap-4">
                                    @include('modules.users.schedules.slug.form')
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
                                        @if (in_array($day['key'], $schedule->days))
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
                        @if ($cuser->has('users:schedules:edit'))
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
                            <div id="edit-scheldule-modal-{{ $schedule->id }}" data-modal-backdrop="static"
                                tabindex="-1" aria-hidden="true"
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
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
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
        <div class="w-full max-lg:hidden">
            <div id="calendar-schedules" class="w-full h-full overflow-y-auto">
            </div>
        </div>
    </div>
@endsection
