@extends('layouts.headers')

@section('app')
    <div style="" id="app" class="h-screen">
        @guest
            @if (Route::has('login'))
            @endif
        @else
            <nav class="fixed pl-[250px] max-sm:pl-0 border-b dark:border-gray-700 w-full border-gray-200 backdrop-blur-md z-30">
                <div class=" flex w-full gap-3 px-4 items-center h-16">
                    <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
                        aria-controls="cta-button-sidebar" type="button"
                        class="inline-flex items-center p-2 mt-2  text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <div class="flex ml-auto items-center md:order-2">
                        <button type="button"
                            class="flex text-sm  rounded-full text-white w-full p-1 pr-3 items-center gap-2 md:mr-0 focus:ring-4 focus:ring-gray-300 bg-[#2b3235]"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">
                            <span class="w-[40px] min-w-[40px] h-[40px] block overflow-hidden rounded-full">
                                <img class="w-full h-full object-cover"
                                    src={{ $colaborador_actual->perfil ? $colaborador_actual->perfil : '/profile-user.png' }}
                                    alt="">
                            </span>
                            <span class="font-medium max-sm:hidden">{{ $colaborador_actual->nombres }}
                                {{ $colaborador_actual->apellidos }}</span>
                            @if ($colaborador_actual->rol == 1 || $colaborador_actual->rol == 2)
                                <span class="p-2 py-1 rounded-full font-normal bg-[#fc5200] text-sm text-white">
                                    {{ $colaborador_actual->rol == 1 ? 'Admin' : 'Developer' }}
                                </span>
                            @endif
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
                                <li>
                                    <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Datos personales
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
                <div class="h-full px-3 py-5 pt-2 flex flex-col overflow-y-auto bg-[#020b0f] shadow-lg">
                    <a href="/" class="flex justify-center py-5 items-center">
                        <img src="/elp.gif" class="w-32" alt="Flowbite Logo" />
                    </a>
                    <div
                        class="grid [&>a>svg]:w-10 [&>a>svg]:mx-auto [&>a>svg]:h-full grid-cols-2 [&>a]:rounded-2xl gap-2 font-medium text-neutral-400">

                        <a href="/meta/{{ $colaborador_actual->id }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is("meta/$colaborador_actual->id*") ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M3 9H21M3 15H21M9 9L9 20M15 9L15 20M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.0799 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                            <span class="flex-1 text-sm">Mis edas</span>
                        </a>

                        <a href="{{ route('auditoria.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('auditoria*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                    stroke="currentColor" stroke-width="1.5"></path>
                            </svg>
                            <span class="flex-1 text-sm">Auditoria</span>
                        </a>

                        <a href="{{ route('reportes.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('reportes*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M10.11 11.1501H7.46005C6.83005 11.1501 6.32007 11.6601 6.32007 12.2901V17.4101H10.11V11.1501V11.1501Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M12.7613 6.6001H11.2413C10.6113 6.6001 10.1013 7.11011 10.1013 7.74011V17.4001H13.8913V7.74011C13.8913 7.11011 13.3913 6.6001 12.7613 6.6001Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M16.5482 12.8501H13.8982V17.4001H17.6882V13.9901C17.6782 13.3601 17.1682 12.8501 16.5482 12.8501Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                            <span class="flex-1 text-sm">Reportes</span>
                        </a>

                        <a href="{{ route('colaboradores.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('colaboradores*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M18.14 21.62C17.26 21.88 16.22 22 15 22H8.99998C7.77998 22 6.73999 21.88 5.85999 21.62C6.07999 19.02 8.74998 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path
                                    d="M15 2H9C4 2 2 4 2 9V15C2 18.78 3.14 20.85 5.86 21.62C6.08 19.02 8.75 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62C20.86 20.85 22 18.78 22 15V9C22 4 20 2 15 2ZM12 14.17C10.02 14.17 8.42 12.56 8.42 10.58C8.42 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58C15.58 12.56 13.98 14.17 12 14.17Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path
                                    d="M15.58 10.58C15.58 12.56 13.98 14.17 12 14.17C10.02 14.17 8.42004 12.56 8.42004 10.58C8.42004 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                            <span class="flex-1 text-sm">Colaboradores</span>
                        </a>

                        <div class="border-b col-span-2 my-1 border-neutral-700"></div>

                        <a href="{{ route('edas.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('edas*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg class="w-7" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="flex-1 text-sm">Edas (Data)</span>
                        </a>

                        <a href="{{ route('cuestionarios.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('cuestionarios*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M8 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 2V5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M21 8.5V13.63C20.11 12.92 18.98 12.5 17.75 12.5C16.52 12.5 15.37 12.93 14.47 13.66C13.26 14.61 12.5 16.1 12.5 17.75C12.5 18.73 12.78 19.67 13.26 20.45C13.63 21.06 14.11 21.59 14.68 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M7 11H13" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7 16H9.62" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M23 17.75C23 18.73 22.72 19.67 22.24 20.45C21.96 20.93 21.61 21.35 21.2 21.69C20.28 22.51 19.08 23 17.75 23C16.6 23 15.54 22.63 14.68 22C14.11 21.59 13.63 21.06 13.26 20.45C12.78 19.67 12.5 18.73 12.5 17.75C12.5 16.1 13.26 14.61 14.47 13.66C15.37 12.93 16.52 12.5 17.75 12.5C18.98 12.5 20.11 12.92 21 13.63C22.22 14.59 23 16.08 23 17.75Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M17.75 20.25C17.75 18.87 18.87 17.75 20.25 17.75C18.87 17.75 17.75 16.63 17.75 15.25C17.75 16.63 16.63 17.75 15.25 17.75C16.63 17.75 17.75 18.87 17.75 20.25Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                            <span class="flex-1 text-sm">Cuestionarios</span>
                        </a>

                        <a href="{{ route('areas.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('areas*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="flex-1 text-sm">Areas</span>
                        </a>

                        <a href="{{ route('departamentos.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('departamentos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="flex-1 text-sm">Departamentos</span>
                        </a>

                        <a href="{{ route('puestos.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('puestos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="flex-1 text-sm">Puestos</span>
                        </a>

                        <a href="{{ route('cargos.index') }}"
                            class="flex flex-col justify-center items-center text-center p-2 h-[100px] group transition-colors {{ request()->is('cargos*') ? 'text-gray-900 bg-gradient-to-tr from-rose-200 via-blue-200 to-green-200' : 'text-slate-300 bg-slate-800/60 hover:bg-neutral-700/50' }}">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 11V17C22 21 21 22 17 22H7C3 22 2 21 2 17V7C2 3 3 2 7 2H8.5C10 2 10.33 2.44 10.9 3.2L12.4 5.2C12.78 5.7 13 6 14 6H17C21 6 22 7 22 11Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                <path d="M8 2H17C19 2 20 3 20 5V6.38" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="flex-1 text-sm">Cargos</span>
                        </a>
                    </div>
                </div>
            </aside>
        @endguest
        <main class="min-h-screen bg-[#fffdfc]">
            @yield('content')
        </main>
    </div>
@endsection
