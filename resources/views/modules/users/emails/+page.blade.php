@extends('modules.users.+layout')

@section('title', 'Emails')

@php
    $access = [
        [
            'name' => 'Pontisis ELP',
            'value' => 'pontisis_elp',
        ],
        [
            'name' => 'Pontisis ILP',
            'value' => 'pontisis_ilp',
        ],
        [
            'name' => 'Pontisis idiomas',
            'value' => 'pontisis_idiomas',
        ],
    ];
@endphp

@section('layout.users')
    <div class="text-black w-full flex-col flex-grow flex overflow-auto">
        <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
            class="bg-blue-700 w-fit shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plus">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            <span class="max-lg:hidden">Asignar nuevo correo</span>
        </button>

        <div id="dialog" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-xl max-h-full bg-white rounded-2xl shadow">
                <div class="flex items-center justify-between p-3 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Asignar correo
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="dialog">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                @include('components.users.auditory-card')
                <form action="/api/emails" method="POST" id="dialog-form" class="p-3 dinamic-form grid gap-4">
                    @include('modules.users.emails.form', [
                        'email' => null,
                    ])
                </form>
                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                    <button form="dialog-form" type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                        Guardar</button>
                    <button id="button-close-scheldule-modal" data-modal-hide="dialog" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                </div>
            </div>
        </div>

        <h2 class="py-3 font-semibold tracking-tight text-lg px-1">
            Gestión de correos
        </h2>
        <div class="p-2 flex o items-center gap-2">
            <div>
                <select name="status" class="dinamic-select">
                    <option selected value="">
                        Estado del correo
                    </option>
                    <option {{ request()->query('status') === 'actives' ? 'selected' : '' }} value="actives">Activos
                    </option>
                    <option {{ request()->query('status') === 'inactives' ? 'selected' : '' }} value="inactives">
                        Inactivos
                    </option>
                </select>
            </div>
            <div class="flex-grow">
                <input value="{{ request()->query('q') }}" class="dinamic-search" type="text"
                    placeholder="Buscar por correo o usuario">
            </div>
            <div>
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
        <div class=" overflow-auto flex-grow">
            <table class="w-full text-left" id="table-users">
                <thead class="border-b">
                    <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                        <th class="w-full">Usuario</th>
                        <th>Estado</th>
                        <th>Email</th>
                        <th class="min-w-[300px]">Descripción</th>
                        <th>Accesos</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if ($emails->count() === 0)
                        <tr class="">
                            <td colspan="11" class="text-center py-4">
                                <div class="p-10">
                                    No hay horarios registrados
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($emails as $email)
                            <tr
                                class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                <td>
                                    <div class="flex items-center gap-4">
                                        <button class="absolute inset-0" data-modal-target="dialog-{{ $email->id }}"
                                            data-modal-toggle="dialog-{{ $email->id }}">
                                        </button>
                                        <div id="dialog-{{ $email->id }}" data-modal-backdrop="static" tabindex="-1"
                                            aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-xl max-h-full bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        Editar correo
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="dialog-{{ $email->id }}">
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
                                                <form action="/api/emails" method="POST"
                                                    id="dialog-{{ $email->id }}-form"
                                                    class="p-3 dinamic-form grid gap-4">
                                                    @include('modules.users.emails.form', [
                                                        'email' => $email,
                                                    ])
                                                </form>
                                                <div class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                    <button form="dialog-{{ $email->id }}-form" type="submit"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                                                        Guardar</button>
                                                    <button id="button-close-scheldule-modal"
                                                        data-modal-hide="dialog-{{ $email->id }}" type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                        @include('commons.avatar', [
                                            'src' => $email->user->profile,
                                            'className' => 'w-12',
                                            'alt' => $email->user->first_name . ' ' . $email->user->last_name,
                                            'altClass' => 'text-lg',
                                        ])
                                        <p class="text-sm font-normal flex-grow text-nowrap">
                                            <span class="text-base block font-semibold">
                                                {{ $email->user->last_name }},
                                                {{ $email->user->first_name }}
                                            </span>
                                            {{ $email->user->dni }} - {{ $email->user->email }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2 font-medium text-sm">
                                        <div class="aspect-square bg-lime-500 rounded-full w-2"></div>
                                        {{ $email->discharged ? 'Dada de baja' : 'Activo' }}
                                    </div>
                                </td>
                                <td class="relative">
                                    <div class="flex items-center gap-2">
                                        <a href="mailto:{{ $email->email }}" title="Enviar correo a {{ $email->email }}"
                                            class="bg-white flex text-sm items-center gap-1 rounded-xl hover:shadow-lg shadow-md p-3 font-medium w-fit">
                                            {{ $email->email }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <p class="line-clamp-2" title="{{ $email->description }}">
                                        {{ $email->description }}
                                    </p>
                                </td>
                                <td>
                                    @php
                                        $emailaccess = $email->access ? json_decode($email->access, true) : [];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        @foreach ($emailaccess as $accessValue)
                                            @foreach ($access as $accessItem)
                                                @if ($accessItem['value'] === $accessValue)
                                                    <div
                                                        class="bg-blue-600 text-white p-1 px-2 shadow-md rounded-full text-sm text-nowrap font-semibold">
                                                        {{ $accessItem['name'] }}</div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
