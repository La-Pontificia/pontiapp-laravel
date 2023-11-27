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
                    <ul class="h-full flex flex-col font-medium text-neutral-400">
                        @if (
                            $a_colaborador &&
                                ($a_colaborador->crear == 1 ||
                                    $a_colaborador->leer == 1 ||
                                    $a_colaborador->eliminar == 1 ||
                                    $a_colaborador->actualizar == 1))
                            <li class="mt-2">
                                <a href="{{ route('colaboradores.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.14 21.62C17.26 21.88 16.22 22 15 22H8.99998C7.77998 22 6.73999 21.88 5.85999 21.62C6.07999 19.02 8.74998 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M15 2H9C4 2 2 4 2 9V15C2 18.78 3.14 20.85 5.86 21.62C6.08 19.02 8.75 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62C20.86 20.85 22 18.78 22 15V9C22 4 20 2 15 2ZM12 14.17C10.02 14.17 8.42 12.56 8.42 10.58C8.42 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58C15.58 12.56 13.98 14.17 12 14.17Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M15.58 10.58C15.58 12.56 13.98 14.17 12 14.17C10.02 14.17 8.42004 12.56 8.42004 10.58C8.42004 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Colaboradores</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_eda && ($a_eda->crear == 1 || $a_eda->leer == 1 || $a_eda->eliminar == 1 || $a_eda->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('edas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('edas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">EDAS</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_area && ($a_area->crear == 1 || $a_area->leer == 1 || $a_area->eliminar == 1 || $a_area->actualizar == 1))
                            <li class="border-t border-neutral-600 pt-2 mt-2">
                                <a href="{{ route('areas.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('areas*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Areas</span>
                                </a>
                            </li>
                        @endif

                        <li class="">
                            <a href="{{ route('cuestionarios.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('cuestionarios*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg class="w-7 scale-110" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M21 8.5V13.63C20.11 12.92 18.98 12.5 17.75 12.5C16.52 12.5 15.37 12.93 14.47 13.66C13.26 14.61 12.5 16.1 12.5 17.75C12.5 18.73 12.78 19.67 13.26 20.45C13.63 21.06 14.11 21.59 14.68 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7 11H13" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7 16H9.62" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M23 17.75C23 18.73 22.72 19.67 22.24 20.45C21.96 20.93 21.61 21.35 21.2 21.69C20.28 22.51 19.08 23 17.75 23C16.6 23 15.54 22.63 14.68 22C14.11 21.59 13.63 21.06 13.26 20.45C12.78 19.67 12.5 18.73 12.5 17.75C12.5 16.1 13.26 14.61 14.47 13.66C15.37 12.93 16.52 12.5 17.75 12.5C18.98 12.5 20.11 12.92 21 13.63C22.22 14.59 23 16.08 23 17.75Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M17.75 20.25C17.75 18.87 18.87 17.75 20.25 17.75C18.87 17.75 17.75 16.63 17.75 15.25C17.75 16.63 16.63 17.75 15.25 17.75C16.63 17.75 17.75 18.87 17.75 20.25Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Cuestionarios</span>
                            </a>
                        </li>

                        <li class="">
                            <a href="{{ route('auditoria.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('cuestionarios*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Auditoria</span>
                            </a>
                        </li>

                        @if (
                            $a_departamento &&
                                ($a_departamento->crear == 1 ||
                                    $a_departamento->leer == 1 ||
                                    $a_departamento->eliminar == 1 ||
                                    $a_departamento->actualizar == 1))
                            <li>
                                <a href="{{ route('departamentos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('departamentos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Departamentos</span>
                                </a>
                            </li>
                        @endif

                        @if ($a_cargo && ($a_cargo->crear == 1 || $a_cargo->leer == 1 || $a_cargo->eliminar == 1 || $a_cargo->actualizar == 1))
                            <li>
                                <a href="{{ route('cargos.index') }}"
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('cargos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
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
                                    class="flex items-center p-2 rounded-lg  hover:text-white group transition-colors {{ request()->is('puestos*') ? 'text-gray-700 bg-gray-100' : '' }}">
                                    <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                        <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
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
