@extends('modules.users.+layout')

@section('title', 'Crear grupo de horario')


@php
    $days = [
        [
            'name' => 'Domingo',
            'value' => 'sunday',
            'key' => 1,
            'short' => 'D',
            'checked' => false,
        ],
        [
            'name' => 'Lunes',
            'value' => 'monday',
            'key' => 2,
            'short' => 'L',
            'checked' => true,
        ],
        [
            'name' => 'Martes',
            'value' => 'tuesday',
            'key' => 3,
            'short' => 'M',
            'checked' => false,
        ],
        [
            'name' => 'Miércoles',
            'value' => 'wednesday',
            'key' => 4,
            'short' => 'M',
            'checked' => false,
        ],
        [
            'name' => 'Jueves',
            'value' => 'thursday',
            'key' => 5,
            'short' => 'J',
            'checked' => false,
        ],
        [
            'name' => 'Viernes',
            'value' => 'friday',
            'key' => 6,
            'short' => 'V',
            'checked' => false,
        ],
        [
            'name' => 'Sábado',
            'value' => 'saturday',
            'key' => 7,
            'short' => 'S',
            'checked' => false,
        ],
    ];
@endphp

@section('layout.users')
    <div class="p-4 space-y-4 flex flex-col">
        <button onclick="window.history.back()" class="bg-white p-2 rounded-xl w-fit flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            Volver atras
        </button>
        <h1 class="text-xl">
            Crear grupo de horario
        </h1>
        <div action="" class="max-w-xl">
            <form action="" id="create-group-schedule">
                <input type="text" required form="create-group-schedule" placeholder="Nombre">
            </form>
            <div class="py-2 px-1 space-y-2">
                <h3 class="font-semibold text-lg">Items</h3>

                <button type="button" data-modal-target="create-scheldule-modal" data-modal-toggle="create-scheldule-modal"
                    class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <span class="max-lg:hidden">Agregar horario</span>
                </button>

                <div id="create-scheldule-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-xl max-h-full">
                        <div class="relative bg-white rounded-2xl shadow">
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
                            <form action="" id="schedule-form" class="p-3 grid gap-4">
                                {{-- <input type="hidden" value="{{ $user->id }}" name="user"> --}}
                                <input value="Horario laboral" type="text" placeholder="Título (Opcional)"
                                    name="title">
                                <div class="flex items-center gap-2">
                                    <div class="p-1">Inicia:</div>
                                    <input required style="width: 170px" type="date" id="start-input"
                                        placeholder="Nombre" name="start">
                                </div>

                                {{-- <div class="flex items-center gap-2">
                                    <div class="p-1 text-nowrap">Repetir cada:</div>
                                    <input required disabled min="1" style="width: 60px; text-align: center"
                                        type="number" value="1" id="repeat" placeholder="0" name="repeat">
                                    <select required disabled name="repeat-type" id="repeat-type">
                                        <option value="week">Semana</option>
                                    </select>
                                </div> --}}

                                <div>
                                    <div class="p-1">Días de la semana:</div>
                                    <div class="flex items-center gap-2">
                                        @foreach ($days as $day)
                                            <label title="{{ $day['name'] }}">
                                                <input data-nostyles {{ $day['checked'] ? 'checked' : '' }}
                                                    class="sr-only peer hidden" type="checkbox" name="days[]"
                                                    value="{{ $day['key'] }}">
                                                <div
                                                    class="peer-checked:bg-blue-600 peer-checked:border-blue-600 cursor-pointer select-none peer-checked:text-white border grid place-content-center w-8 text-sm aspect-square rounded-full p-1">
                                                    {{ $day['short'] }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex border-y py-3 flex-col gap-2">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1">Hora de inicio:</div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input min="05:00" max="23:00" required type="time" value="05:00"
                                                id="from-input" name="from">
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="p-1">Hora fin:</div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input min="05:00" max="23:00" required type="time" id="to-input"
                                                name="to">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="p-1">Finaliza:</div>
                                    <input style="width: 170px" type="date" id="end-input" name="end">
                                </div>
                            </form>
                            <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                <button form="schedule-form" data-modal-hide="static-modal" type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                    Guardar</button>
                                <button id="button-close-scheldule-modal" data-modal-hide="create-scheldule-modal"
                                    type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
