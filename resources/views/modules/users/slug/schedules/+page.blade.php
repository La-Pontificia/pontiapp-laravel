@extends('modules.users.slug.+layout')

@section('title', 'Horario: ' . $user->first_name . ', ' . $user->last_name)

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


@section('layout.users.slug')
    <div class="flex w-full overflow-y-auto">
        <div class="rounded-2xl w-[350px] h-full flex flex-col px-1 overflow-y-auto">
            <input type="hidden" value="{{ $user->group_schedule_id }}" id="group_schedule_id">
            <div class="py-3 pr-6">
                <p class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class=" z-10 w-4 text-stone-500 top-3.5 left-3" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-plus-2">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                        <path d="M10 16h4" />
                        <path d="M12 14v4" />
                    </svg>
                    Horario de {{ $user->groupSchedule->name }}
                </p>
            </div>
            <div class="">
                <button id="button-create-scheldule-modal" data-modal-target="create-scheldule-modal"
                    data-modal-toggle="create-scheldule-modal" class="hidden">
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
                                <input type="hidden" value="{{ $user->id }}" name="user">
                                <input value="Horario laboral" type="text" placeholder="Título (Opcional)"
                                    name="title">
                                <div class="flex items-center gap-2">
                                    <div class="p-1">Inicia:</div>
                                    <input required style="width: 170px" type="date" id="start-input"
                                        placeholder="Nombre" name="start">
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="p-1 text-nowrap">Repetir cada:</div>
                                    <input required disabled min="1" style="width: 60px; text-align: center"
                                        type="number" value="1" id="repeat" placeholder="0" name="repeat">
                                    <select required disabled name="repeat-type" id="repeat-type">
                                        <option value="week">Semana</option>
                                    </select>
                                </div>
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
                                <button form="schedule-form" type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                    Guardar</button>
                                <button id="button-close-scheldule-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($schedules->isEmpty())
                <div class="py-10">
                    <p class="text-gray-500 text-center">No hay horarios disponibles</p>
                </div>
            @endif
            <div class="space-y-4 overflow-y-auto  pr-6">
                @foreach ($schedules as $schedule)
                    @php
                        $from = date('h:i A', strtotime($schedule->from));
                        $to = date('h:i A', strtotime($schedule->to));
                        $daysJson = json_decode($schedule->days);
                    @endphp
                    <div data-active data-id="{{ $schedule->id }}"
                        class="text-black opacity-50 hover:opacity-100 transition-all data-[active]:opacity-100 min-h-36 schedule group relative overflow-hidden shadow-sm bg-white hover:shadow-lg cursor-pointer rounded-2xl flex">
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
                @endforeach
            </div>
        </div>
        <div class="flex-grow overflow-y-auto">
            <div class="w-full h-full overflow-y-auto" id="calendar-user-slug">
            </div>
        </div>
    </div>
@endsection
