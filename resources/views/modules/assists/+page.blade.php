@extends('modules.assists.+layout')

@php
    $branches = [
        [
            'name' => 'PL Alameda',
            'value' => 'pl-alameda',
        ],
        [
            'name' => 'PL Andahuaylas',
            'value' => 'pl-andahuaylas',
        ],
        [
            'name' => 'PL Casuarina',
            'value' => 'pl-casuarina',
        ],
        [
            'name' => 'PL Cybernet',
            'value' => 'pl-cybernet',
        ],
        [
            'name' => 'PL Jazmines',
            'value' => 'pl-jazmines',
        ],
        [
            'name' => 'RH Alameda',
            'value' => 'rh-alameda',
        ],
        [
            'name' => 'RH Andahuaylas',
            'value' => 'rh-andahuaylas',
        ],
        [
            'name' => 'RH Casuarina',
            'value' => 'rh-casuarina',
        ],
        [
            'name' => 'RH Jazmines',
            'value' => 'rh-jazmines',
        ],
    ];

    $start = request()->query('start_date') ? request()->query('start_date') : null;
    $end = request()->query('end_date') ? request()->query('end_date') : null;
@endphp

@section('layout.assists')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        {{-- <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-2">
            Gestion de asistencias
        </h2> --}}
        <div class="px-1 gap-3 flex items-center">
            <div>
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
            <div class="pt-2 flex w-full items-center gap-2">
                <div>
                    <select name="branch" class="dinamic-select">
                        @foreach ($branches as $branch)
                            <option {{ request()->query('branch') === $branch['value'] ? 'selected' : '' }}
                                value="{{ $branch['value'] }}">{{ $branch['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-grow">
                    <input value="{{ request()->query('q') }}" type="search" placeholder="DNI"
                        class="dinamic-search w-[200px] text-black outline-0 border border-neutral-300 flex items-center rounded-full gap-2 p-1.5 text-sm px-3 bg-neutral-100">
                </div>
                <button
                    class="bg-white hover:shadow-md flex items-center rounded-full gap-2 p-2 text-sm font-semibold px-3">
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
                            <path
                                d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z"
                                style="opacity:0.10000000149011612;isolation:isolate"></path>
                            <path
                                d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                            <path
                                d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z"
                                style="opacity:0.20000000298023224;isolation:isolate"></path>
                            <path
                                d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z"
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
        </div>
        <div class="overflow-auto flex flex-col">
            <table class="w-full relative overflow-x-auto">
                <thead class="border-b sticky bg-[#f1f0f4] divide-y top-0 z-10">
                    <tr class="text-left [&>th]:px-3 [&>th]:py-3 [&>th]:font-medium">
                        <th class="w-full">Usuario</th>
                        <th>Sede</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assists as $assist)
                        @php
                            $user = $assist->getUserFromMysql();
                        @endphp

                        <tr class="border-b group [&>td]:px-3 [&>td]:py-3">
                            <td>
                                @if ($user)
                                    <div class="flex items-center gap-3">
                                        @include('commons.avatar', [
                                            'src' => $user->profile,
                                            'className' => 'w-12',
                                            'alt' => $user->first_name . ' ' . $user->last_name,
                                            'altClass' => 'text-lg',
                                        ])
                                        <div class="flex-grow">
                                            <a href="/profile/{{ $user->id }}"
                                                title="Ver perfil de {{ $user->last_name }}, {{ $user->first_name }}"
                                                class="hover:underline font-medium text-blue-700 text-nowrap">
                                                {{ $user->last_name ?? '-' }}, {{ $user->first_name ?? '-' }}
                                            </a>
                                            <p class="text-sm font-normal text-nowrap">
                                                {{ $user->role_position->job_position->name }},
                                                {{ $user->role_position->name }},
                                                {{ $user->role_position->department->area->name }}
                                            </p>
                                        </div>
                                        <div>
                                            <pre>
                                                {{ $user->schedules()[0]['title'] }}
                                            </pre>
                                        </div>
                                        <a href="{{ route('assists.user', ['id_user' => $user->id]) }}"
                                            class="group-hover:opacity-100 text-nowrap opacity-0 gap-2 flex items-center border p-1.5 rounded-xl hover:border-stone-400 px-2"
                                            title="Ver asistencias y horarios de {{ $user->last_name }}, {{ $user->first_name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-square-arrow-up-right opacity-60">
                                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                                <path d="M8 8h8v8" />
                                                <path d="m8 16 8-8" />
                                            </svg>
                                            Ver asistencias y horarios
                                        </a>
                                    </div>
                                @else
                                    <p class="font-semibold text-nowrap text-sm opacity-60">
                                        {{ $assist->first_name }}, {{ $assist->last_name }} | {{ $assist->emp_code }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                <p class="text-nowrap font-semibold">
                                    {{ $assist->dept_name }}
                                </p>
                            </td>
                            <td>
                                <p class="flex items-center text-nowrap gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide opacity-50 lucide-calendar-days">
                                        <path d="M8 2v4" />
                                        <path d="M16 2v4" />
                                        <rect width="18" height="18" x="3" y="4" rx="2" />
                                        <path d="M3 10h18" />
                                        <path d="M8 14h.01" />
                                        <path d="M12 14h.01" />
                                        <path d="M16 14h.01" />
                                        <path d="M8 18h.01" />
                                        <path d="M12 18h.01" />
                                        <path d="M16 18h.01" />
                                    </svg>
                                    {{ date('d/m/Y', strtotime($assist->punch_time)) }}
                                </p>
                            </td>
                            <td>
                                <p class="text-nowrap items-center flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide opacity-50 lucide-clock">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    @if ($assist->punch_time)
                                        {{ date('h:i:s A', strtotime($assist->punch_time)) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </td>
                            {{-- <td>
                                    <p class="text-nowrap">
                                        @if ($assist->upload_time)
                                            {{ date('h:i:s A', strtotime($assist->upload_time)) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="px-5 pt-4">
            {!! $assists->links() !!}
        </footer>
    </div>
@endsection
