@extends('layouts.headers')

@section('app')
    <div style="" id="app" class="h-screen">
        @guest
            @if (Route::has('login'))
            @endif
        @else
            <nav class="fixed pl-[250px] border-b dark:border-gray-700 w-full border-gray-200 bg-white backdrop-blur-sm z-30">
                <div class=" flex w-full gap-3 px-4 items-center h-16">
                    <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
                        aria-controls="cta-button-sidebar" type="button"
                        class="inline-flex items-center p-2 mt-2  text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-100 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <div class="flex ml-auto items-center md:order-2">
                        <button type="button"
                            class="flex text-sm border border-gray-300 w-full p-1 pr-3 items-center gap-2 rounded-lg md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <img class="w-9 h-9 rounded-full" src="/profile-user.png" alt="user photo">
                            <span class="font-medium">{{ $colaborador_actual->nombres }}
                                {{ $colaborador_actual->apellidos }}</span>
                        </button>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="user-dropdown">
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                <li>
                                    <a href="/meta/{{ $colaborador_actual->id }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Mis edas
                                    </a>
                                </li>
                            </ul>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cerrar
                                    sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </div>
                    </div>
                </div>
            </nav>
            <aside id="cta-button-sidebar"
                class="fixed top-0 left-0 z-40 w-[250px] h-screen transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-5 pt-2 flex flex-col overflow-y-auto bg-gray-950 shadow-lg">
                    <a href="/" class="flex justify-center items-center">
                        <img src="/elp.gif" class="w-32" alt="Flowbite Logo" />
                    </a>
                    <ul class="h-full flex flex-col font-medium text-neutral-500">
                        {{-- <li class="bg-gray-200 rounded-xl">
                            <div
                                class="flex items-center bg-gray-200 rounded-xl w-full p-2 pb-0 text-base text-gray-900 transition duration-75">
                                <div class="w-[35px] h-[35px] rounded-full overflow-hidden border border-neutral-300">
                                    <img class="object-cover w-full h-full" src="/profile-user.png" alt="user photo">
                                </div>
                                <span class="flex-1 ml-3 line-clamp-1 text-left">{{ $colaborador_actual->nombres }}
                                    {{ $colaborador_actual->apellidos }}</span>
                            </div>
                            <ul class=" p-2 pl-5">
                                @if ($a_objetivo && ($a_objetivo->crear == 1 || $a_objetivo->leer == 1 || $a_objetivo->eliminar == 1 || $a_objetivo->actualizar == 1))
                                    <li>
                                        <a href="/meta/{{ $colaborador_actual->id }}"
                                            class="flex gap-2 text-gray-900 {{ request()->is('me/eda') ? 'bg-gray-800 text-white' : 'hover:bg-gray-100' }} items-center w-full p-2  transition duration-75 rounded-lg group">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.5 2C8.67157 2 8 2.67157 8 3.5V4.5C8 5.32843 8.67157 6 9.5 6H14.5C15.3284 6 16 5.32843 16 4.5V3.5C16 2.67157 15.3284 2 14.5 2H9.5Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.5 4.03662C5.24209 4.10719 4.44798 4.30764 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.552 4.30764 18.7579 4.10719 17.5 4.03662V4.5C17.5 6.15685 16.1569 7.5 14.5 7.5H9.5C7.84315 7.5 6.5 6.15685 6.5 4.5V4.03662ZM7 9.75C6.58579 9.75 6.25 10.0858 6.25 10.5C6.25 10.9142 6.58579 11.25 7 11.25H7.5C7.91421 11.25 8.25 10.9142 8.25 10.5C8.25 10.0858 7.91421 9.75 7.5 9.75H7ZM10.5 9.75C10.0858 9.75 9.75 10.0858 9.75 10.5C9.75 10.9142 10.0858 11.25 10.5 11.25H17C17.4142 11.25 17.75 10.9142 17.75 10.5C17.75 10.0858 17.4142 9.75 17 9.75H10.5ZM7 13.25C6.58579 13.25 6.25 13.5858 6.25 14C6.25 14.4142 6.58579 14.75 7 14.75H7.5C7.91421 14.75 8.25 14.4142 8.25 14C8.25 13.5858 7.91421 13.25 7.5 13.25H7ZM10.5 13.25C10.0858 13.25 9.75 13.5858 9.75 14C9.75 14.4142 10.0858 14.75 10.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14C17.75 13.5858 17.4142 13.25 17 13.25H10.5ZM7 16.75C6.58579 16.75 6.25 17.0858 6.25 17.5C6.25 17.9142 6.58579 18.25 7 18.25H7.5C7.91421 18.25 8.25 17.9142 8.25 17.5C8.25 17.0858 7.91421 16.75 7.5 16.75H7ZM10.5 16.75C10.0858 16.75 9.75 17.0858 9.75 17.5C9.75 17.9142 10.0858 18.25 10.5 18.25H17C17.4142 18.25 17.75 17.9142 17.75 17.5C17.75 17.0858 17.4142 16.75 17 16.75H10.5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span>
                                                Edas
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/me/eda"
                                            class="flex gap-2 text-gray-900 {{ request()->is('me/eda') ? 'bg-gray-800 text-white' : 'hover:bg-gray-100' }} items-center w-full p-2  transition duration-75 rounded-lg group">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.5 2C8.67157 2 8 2.67157 8 3.5V4.5C8 5.32843 8.67157 6 9.5 6H14.5C15.3284 6 16 5.32843 16 4.5V3.5C16 2.67157 15.3284 2 14.5 2H9.5Z"
                                                    fill="currentColor"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.5 4.03662C5.24209 4.10719 4.44798 4.30764 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.552 4.30764 18.7579 4.10719 17.5 4.03662V4.5C17.5 6.15685 16.1569 7.5 14.5 7.5H9.5C7.84315 7.5 6.5 6.15685 6.5 4.5V4.03662ZM7 9.75C6.58579 9.75 6.25 10.0858 6.25 10.5C6.25 10.9142 6.58579 11.25 7 11.25H7.5C7.91421 11.25 8.25 10.9142 8.25 10.5C8.25 10.0858 7.91421 9.75 7.5 9.75H7ZM10.5 9.75C10.0858 9.75 9.75 10.0858 9.75 10.5C9.75 10.9142 10.0858 11.25 10.5 11.25H17C17.4142 11.25 17.75 10.9142 17.75 10.5C17.75 10.0858 17.4142 9.75 17 9.75H10.5ZM7 13.25C6.58579 13.25 6.25 13.5858 6.25 14C6.25 14.4142 6.58579 14.75 7 14.75H7.5C7.91421 14.75 8.25 14.4142 8.25 14C8.25 13.5858 7.91421 13.25 7.5 13.25H7ZM10.5 13.25C10.0858 13.25 9.75 13.5858 9.75 14C9.75 14.4142 10.0858 14.75 10.5 14.75H17C17.4142 14.75 17.75 14.4142 17.75 14C17.75 13.5858 17.4142 13.25 17 13.25H10.5ZM7 16.75C6.58579 16.75 6.25 17.0858 6.25 17.5C6.25 17.9142 6.58579 18.25 7 18.25H7.5C7.91421 18.25 8.25 17.9142 8.25 17.5C8.25 17.0858 7.91421 16.75 7.5 16.75H7ZM10.5 16.75C10.0858 16.75 9.75 17.0858 9.75 17.5C9.75 17.9142 10.0858 18.25 10.5 18.25H17C17.4142 18.25 17.75 17.9142 17.75 17.5C17.75 17.0858 17.4142 16.75 17 16.75H10.5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                            <span>
                                                Feedbacks
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li> --}}
                        @if (
                            $a_colaborador &&
                                ($a_colaborador->crear == 1 ||
                                    $a_colaborador->leer == 1 ||
                                    $a_colaborador->eliminar == 1 ||
                                    $a_colaborador->actualizar == 1))
                            <li class="mt-2">
                                <a href="{{ route('colaboradores.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4.333 6.764a3 3 0 1 1 3.141-5.023M2.5 16H1v-2a4 4 0 0 1 4-4m7.379-8.121a3 3 0 1 1 2.976 5M15 10a4 4 0 0 1 4 4v2h-1.761M13 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-4 6h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Colaboradores</span>
                                </a>
                            </li>
                        @endif
                        {{-- @if ($a_acceso && ($a_acceso->crear == 1 || $a_acceso->leer == 1 || $a_acceso->eliminar == 1 || $a_acceso->actualizar == 1))
                            <li>
                                <a href="{{ route('accesos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('accesos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg height="33"viewBox="0 0 64 64" id="Layer_1" version="1.1"
                                        xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #B4E6DD;
                                                }

                                                .st1 {
                                                    fill: #80D4C4;
                                                }

                                                .st2 {
                                                    fill: #D2F0EA;
                                                }

                                                .st3 {
                                                    fill: #FFFFFF;
                                                }

                                                .st4 {
                                                    fill: #FBD872;
                                                }

                                                .st5 {
                                                    fill: #ea5039;
                                                }

                                                .st6 {
                                                    fill: #bd4a32;
                                                }

                                                .st7 {
                                                    fill: #F6AF62;
                                                }

                                                .st8 {
                                                    fill: #32A48E;
                                                }

                                                .st9 {
                                                    fill: #A38FD8;
                                                }

                                                .st10 {
                                                    fill: #7C64BD;
                                                }

                                                .st11 {
                                                    fill: #EAA157;
                                                }

                                                .st12 {
                                                    fill: #9681CF;
                                                }

                                                .st13 {
                                                    fill: #F9C46A;
                                                }

                                                .st14 {
                                                    fill: #CE6B61;
                                                }
                                            </style>
                                            <g>
                                                <path class="st1"
                                                    d="M44,16H12c-2.21,0-4,1.79-4,4v32c0,2.21,1.79,4,4,4h32c2.21,0,4-1.79,4-4V20C48,17.79,46.21,16,44,16z">
                                                </path>
                                                <rect class="st3" height="32"
                                                    transform="matrix(-1.836970e-16 1 -1 -1.836970e-16 66.9968 11.0031)"
                                                    width="26" x="15" y="23"></rect>
                                                <g>
                                                    <circle class="st3" cx="14" cy="21" r="2">
                                                    </circle>
                                                    <circle class="st3" cx="20" cy="21" r="2">
                                                    </circle>
                                                </g>
                                                <path class="st6"
                                                    d="M55.66,13.82l-0.4-2.42L49.66,8c-5.1,3.09-11.49,3.09-16.59,0l-5.59,3.39l-0.39,2.38 c-1.86,11.24,3.97,22.34,14.28,27.19l0.01,0C51.68,36.14,57.52,25.05,55.66,13.82z">
                                                </path>
                                                <path class="st5"
                                                    d="M49.37,23h-16v12.05c2.2,2.43,4.89,4.46,7.99,5.92l0.01,0c3.11-1.45,5.8-3.49,8-5.91V23z">
                                                </path>
                                                <circle class="st4" cx="41.37" cy="23" r="8">
                                                </circle>
                                            </g>
                                        </g>
                                    </svg>
                                       <span class="flex-1 ml-3 whitespace-nowrap">Accesos</span>
                                </a>
                            </li>
                        @endif --}}
                        @if ($a_eda && ($a_eda->crear == 1 || $a_eda->leer == 1 || $a_eda->eliminar == 1 || $a_eda->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('edas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('edas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1Zm0 0V2a1 1 0 0 1 1-1h5.443a1 1 0 0 1 .8.4l2.7 3.6H1Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">EDAS</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_area && ($a_area->crear == 1 || $a_area->leer == 1 || $a_area->eliminar == 1 || $a_area->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('areas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('areas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1Zm0 0V2a1 1 0 0 1 1-1h5.443a1 1 0 0 1 .8.4l2.7 3.6H1Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Areas</span>
                                </a>
                            </li>
                        @endif


                        @if (
                            $a_departamento &&
                                ($a_departamento->crear == 1 ||
                                    $a_departamento->leer == 1 ||
                                    $a_departamento->eliminar == 1 ||
                                    $a_departamento->actualizar == 1))
                            <li>
                                <a href="{{ route('departamentos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('departamentos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1Zm0 0V2a1 1 0 0 1 1-1h5.443a1 1 0 0 1 .8.4l2.7 3.6H1Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Departamentos</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_cargo && ($a_cargo->crear == 1 || $a_cargo->leer == 1 || $a_cargo->eliminar == 1 || $a_cargo->actualizar == 1))
                            <li>
                                <a href="{{ route('cargos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('cargos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1Zm0 0V2a1 1 0 0 1 1-1h5.443a1 1 0 0 1 .8.4l2.7 3.6H1Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Cargos</span>
                                </a>
                            </li>
                        @endif
                        @if (
                            $a_puesto &&
                                ($a_puesto->crear == 1 || $a_puesto->leer == 1 || $a_puesto->eliminar == 1 || $a_puesto->actualizar == 1))
                            <li>
                                <a href="{{ route('puestos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:bg-gray-100 group transition-colors {{ request()->is('puestos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 5v11a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1Zm0 0V2a1 1 0 0 1 1-1h5.443a1 1 0 0 1 .8.4l2.7 3.6H1Z" />
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Puestos</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>
        @endguest
        <main class="min-h-screen">
            @yield('content')
        </main>
    </div>
@endsection
