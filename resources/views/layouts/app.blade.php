<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="resources/css/app.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen">

    <div style="" id="app" class="h-screen">
        <button data-drawer-target="cta-button-sidebar" data-drawer-toggle="cta-button-sidebar"
            aria-controls="cta-button-sidebar" type="button"
            class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                </path>
            </svg>
        </button>
        @guest
            @if (Route::has('login'))
                {{-- <li class="">
                    <a class="nav-link font-semibold text-xl" class="font-semibold"
                        href="{{ route('login') }}">{{ __('Login') }}</a>
                </li> --}}
            @endif
        @else
            <aside id="cta-button-sidebar"
                class="fixed top-0 left-0 z-40 w-[300px] h-screen transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 py-4 pt-2 flex flex-col overflow-y-auto bg-zinc-900">
                    <a href="{{ url('/') }}" class="flex items-center p-3">
                        <img src="/elp.gif" class="h-14 mr-3" alt="Flowbite Logo" />
                    </a>
                    <ul class="gap-2 h-full flex flex-col font-medium text-neutral-300">
                        <li>
                            <a href="{{ route('objetivos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('objetivos*') || request()->is('calificar*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v2H7V2ZM5 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm8 4H8a1 1 0 0 1 0-2h5a1 1 0 0 1 0 2Zm0-4H8a1 1 0 0 1 0-2h5a1 1 0 1 1 0 2Z" />
                                </svg>
                                <span class="ml-3">Objetivos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colaboradores.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('colaboradores*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="w-[40px] block {{ request()->is('colaboradores*') ? 'text-rose-400 ' : '' }}"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.5"
                                            d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M16.807 19.0112C15.4398 19.9504 13.7841 20.5 12 20.5C10.2159 20.5 8.56023 19.9503 7.193 19.0111C6.58915 18.5963 6.33109 17.8062 6.68219 17.1632C7.41001 15.8302 8.90973 15 12 15C15.0903 15 16.59 15.8303 17.3178 17.1632C17.6689 17.8062 17.4108 18.5964 16.807 19.0112Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3432 6 9.00004 7.34315 9.00004 9C9.00004 10.6569 10.3432 12 12 12Z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Colaboradores</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('supervisores.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('supervisores*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="w-[40px] block {{ request()->is('supervisores*') ? 'text-yellow-400 ' : '' }}"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_iconCarrier">
                                        <path opacity="0.5"
                                            d="M14 4H10C6.22876 4 4.34315 4 3.17157 5.17157C2 6.34315 2 8.22876 2 12C2 15.7712 2 17.6569 3.17157 18.8284C4.34315 20 6.22876 20 10 20H14C17.7712 20 19.6569 20 20.8284 18.8284C22 17.6569 22 15.7712 22 12C22 8.22876 22 6.34315 20.8284 5.17157C19.6569 4 17.7712 4 14 4Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M13.25 9C13.25 8.58579 13.5858 8.25 14 8.25H19C19.4142 8.25 19.75 8.58579 19.75 9C19.75 9.41421 19.4142 9.75 19 9.75H14C13.5858 9.75 13.25 9.41421 13.25 9Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M14.25 12C14.25 11.5858 14.5858 11.25 15 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H15C14.5858 12.75 14.25 12.4142 14.25 12Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M15.25 15C15.25 14.5858 15.5858 14.25 16 14.25H19C19.4142 14.25 19.75 14.5858 19.75 15C19.75 15.4142 19.4142 15.75 19 15.75H16C15.5858 15.75 15.25 15.4142 15.25 15Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M9 11C10.1046 11 11 10.1046 11 9C11 7.89543 10.1046 7 9 7C7.89543 7 7 7.89543 7 9C7 10.1046 7.89543 11 9 11Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M9 17C13 17 13 16.1046 13 15C13 13.8954 11.2091 13 9 13C6.79086 13 5 13.8954 5 15C5 16.1046 5 17 9 17Z"
                                            fill="currentColor"></path>
                                    </g>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Supervisores</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('accesos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('accesos*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover: dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Accesos</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('accesos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('accesos*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.333 6.764a3 3 0 1 1 3.141-5.023M2.5 16H1v-2a4 4 0 0 1 4-4m7.379-8.121a3 3 0 1 1 2.976 5M15 10a4 4 0 0 1 4 4v2h-1.761M13 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-4 6h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Usuarios</span>
                            </a>
                        </li> --}}
                        <li class="border-t border-t-neutral-700 pt-2 mt-2">
                            <a href="{{ route('areas.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('areas*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6  transition duration-75 text-gray-500 dark:text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M18 5H0v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-7.258-2L9.092.8a2.009 2.009 0 0 0-1.6-.8H2.049a2 2 0 0 0-2 2v1h10.693Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Areas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('departamentos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('departamentos*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6  transition duration-75 text-gray-500 dark:text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M18 5H0v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-7.258-2L9.092.8a2.009 2.009 0 0 0-1.6-.8H2.049a2 2 0 0 0-2 2v1h10.693Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Departamentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cargos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('cargos*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6  transition duration-75 text-gray-500 dark:text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M18 5H0v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-7.258-2L9.092.8a2.009 2.009 0 0 0-1.6-.8H2.049a2 2 0 0 0-2 2v1h10.693Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Cargos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('puestos.index') }}"
                                class="flex items-center p-2 rounded-lg  hover:bg-gray-700 group transition-colors {{ request()->is('puestos*') ? 'text-white bg-zinc-700' : '' }}">
                                <svg class="flex-shrink-0 w-6 h-6  transition duration-75 text-gray-500 dark:text-gray-400 group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 18">
                                    <path
                                        d="M18 5H0v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-7.258-2L9.092.8a2.009 2.009 0 0 0-1.6-.8H2.049a2 2 0 0 0-2 2v1h10.693Z" />
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Puestos</span>
                            </a>
                        </li>

                        <div class="flex flex-col gap-2">
                            @foreach ($objetivosDesaprobados as $objetivoDesaprobado)
                                @php
                                    $fechaFeedback = \Carbon\Carbon::parse($objetivoDesaprobado->feedback_fecha);
                                    $diferencia = $fechaFeedback->diffForHumans();
                                @endphp
                                <a href="">
                                    <div id="toast-notification"
                                        class="w-full max-w-xs p-2 text-gray-100 bg-neutral-700 rounded-lg shadow dark:bg-gray-800 dark:text-gray-300"
                                        role="alert">

                                        <div class="flex items-center">
                                            <div class="relative inline-block shrink-0">
                                                <img class="w-12 h-12 rounded-full" src="/default-user.webp"
                                                    alt="Jese Leos image" />
                                                <span
                                                    class="absolute bottom-0 right-0 inline-flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full">
                                                    <svg class="w-3 h-3 text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 18"
                                                        fill="currentColor">
                                                        <path
                                                            d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="ml-3 text-sm font-normal">
                                                <div class="text-sm font-semibold text-gray-100">
                                                    {{ $objetivoDesaprobado->supervisor->nombres }}
                                                    {{ $objetivoDesaprobado->supervisor->apellidos }}
                                                </div>
                                                <div class="text-sm font-normal">Tienes un nuevo feedback</div>
                                                <span
                                                    class="text-xs font-medium text-blue-600 dark:text-blue-500">{{ $diferencia }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <li class="nav-item dropdown mt-auto">
                            <button type="button"
                                class="flex mr-3 text-sm bg-gray-800 w-full p-2 items-center gap-2 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                                data-dropdown-placement="bottom">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="/default-user.webp" alt="user photo">
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="user-dropdown">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
                                    <span
                                        class="block text-sm  text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                                </div>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Cerrar
                                            sesión</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </aside>
        @endguest
        <main class="h-screen">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    @yield('script')
</body>

</html>
