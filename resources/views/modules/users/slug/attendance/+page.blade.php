@extends('modules.users.slug.+layout')

@section('title', 'Asistencias: ' . $user->first_name . ', ' . $user->last_name)

@php

    $start = request()->query('start_date') ? request()->query('start_date') : null;
    $end = request()->query('end_date') ? request()->query('end_date') : null;
@endphp

@section('layout.users.slug')
    <div class="space-y-2 flex h-full flex-col">
        <div class="p-1 flex items-end">
            <div class="flex-grow">
                <p class="py-2 font-semibold text-xs opacity-70">
                    Rango de fecha
                </p>
                <div id="date-range" class="flex items-center gap-1 w-[340px]">
                    <input readonly {{ $start ? "data-default=$start" : '' }} type="text" name="start" placeholder="-">
                    <span>a</span>
                    <input readonly {{ $end ? "data-default=$end" : '' }} type="text" name="end" placeholder="-">

                    <button id="filter"
                        class="p-2 rounded-xl bg-green-600 px-2 text-sm text-white shadow-sm font-semibold">Filtrar</button>
                </div>
                <p class="text-xs p-1 text-yellow-600">
                    Se recomienda máximo 1 mes de rango de fecha.
                </p>
            </div>
            <button class="bg-white hover:shadow-md flex items-center rounded-full gap-2 p-2 text-sm font-semibold px-3">
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
                        <title>file_type_excel</title>
                        <path
                            d="M19.581,15.35,8.512,13.4V27.809A1.192,1.192,0,0,0,9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5Z"
                            style="fill:#185c37"></path>
                        <path d="M19.581,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5L19.581,16l5.861,1.95L30,16V9.5Z"
                            style="fill:#21a366"></path>
                        <path d="M8.512,9.5H19.581V16H8.512Z" style="fill:#107c41"></path>
                        <path d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z"
                            style="opacity:0.10000000149011612;isolation:isolate"></path>
                        <path d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                            style="opacity:0.20000000298023224;isolation:isolate"></path>
                        <path d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                            style="opacity:0.20000000298023224;isolation:isolate"></path>
                        <path d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z"
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
        <div class="bg-white h-full shadow-sm rounded-2xl overflow-auto mt-5">
            <table data-value="{{ $user->id }}" class="w-full text-left relative">
                <thead class="border-b sticky top-0 z-[1] bg-white">
                    <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-3">
                        <th class="w-full font-semibold tracking-tight">Horario</th>
                        <th>Sede</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Asistencia</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y z-[0]">
                    @if (count($schedules) === 0)
                        <tr class="">
                            <td colspan="11" class="text-center py-4">
                                <div class="p-10">
                                    No hay roles disponibles
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($schedules as $schedule)
                            <tr
                                class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-3">
                                <td data-value="{{ $schedule['title'] }}">
                                    <p class="text-nowrap">
                                        {{ $schedule['title'] }}
                                    </p>
                                </td>
                                <td data-value="{{ $schedule['dept_name'] }}">
                                    <p class="text-nowrap">
                                        {{ $schedule['dept_name'] }}
                                    </p>
                                </td>
                                <td data-value="{{ $schedule['from'] }}">
                                    <p class="text-nowrap flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-calendar opacity-70">
                                            <path d="M8 2v4" />
                                            <path d="M16 2v4" />
                                            <rect width="18" height="18" x="3" y="4" rx="2" />
                                            <path d="M3 10h18" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($schedule['from'])->isoFormat('LL') }}
                                    </p>
                                </td>
                                <td data-value="{{ $schedule['from'] }},{{ $schedule['to'] }}">
                                    <p
                                        class="text-nowrap flex text-sm items-center gap-2 bg-blue-600 p-1 rounded-md text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-clock">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        {{ date('h:i A', strtotime($schedule['from'])) }} -
                                        {{ date('h:i A', strtotime($schedule['to'])) }}
                                    </p>
                                </td>

                                <td data-value="{{ $schedule['i_enter'] }},{{ $schedule['he_left'] }}">
                                    @if ($schedule['i_enter'] || $schedule['he_left'])
                                        <p
                                            class="text-nowrap w-fit flex items-center text-sm gap-2 p-1 rounded-md px-2 bg-green-600 text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-clock">
                                                <circle cx="12" cy="12" r="10" />
                                                <polyline points="12 6 12 12 16 14" />
                                            </svg>
                                            {{ $schedule['i_enter'] ? date('h:i A', strtotime($schedule['i_enter'])) : '-' }}
                                            /
                                            {{ $schedule['he_left'] ? date('h:i A', strtotime($schedule['he_left'])) : '-' }}
                                        </p>
                                    @endif
                                </td>

                                <td>
                                    <p>
                                        @if ($schedule['time_worked'] !== null)
                                            @if ($schedule['time_worked'] >= 60)
                                                {{ floor($schedule['time_worked'] / 60) }} horas con
                                                {{ $schedule['time_worked'] % 60 }} minutos
                                            @else
                                                {{ $schedule['time_worked'] }} minutos
                                            @endif
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
