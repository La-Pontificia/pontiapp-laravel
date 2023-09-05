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




    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav style="position: sticky; top: 0; z-index: 999;"
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="custom_container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/elp.gif" style="width: 140px;" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto" style="display: flex; gap: 5px; align-items: center;">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link font-semibold text-xl" class="font-semibold"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            @if ($accesos->contains('modulo', 'Mantenimiento'))
                                <li class="nav-item" style="border-right: solid 1px rgba(0,0,0,.3);">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('mantenimiento*') ? 'text-primary' : '' }}"
                                        href="{{ route('mantenimiento.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-server"></i>
                                        <span style="font-size: 13px;">{{ __('Mantenimiento') }}</span></a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                    class="nav-link {{ request()->is('objetivos*') ? 'text-primary' : '' }}"
                                    href="{{ route('objetivos.index') }}"><i style="font-size: 30px"
                                        class="fa-solid fa-list-check"></i>

                                    <span style="font-size: 13px;">{{ __('Mis Objetivos') }}</span></a>
                            </li>
                            {{-- @if ($accesos->contains('modulo', 'Supervisores'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('supervisores*') ? 'text-primary' : '' }}"
                                        href="{{ route('supervisores.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-user-tie"></i>
                                        <span style="font-size: 13px;">{{ __('Supervisores') }}</span></a>
                                </li>
                            @endif --}}
                            @if ($accesos->contains('modulo', 'Colaboradores'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('colaboradores*') ? 'text-primary' : '' }}"
                                        href="{{ route('colaboradores.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-users"></i>
                                        <span style="font-size: 13px;">{{ __('Colaboradores') }}</span></a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                    class="nav-link" href="{{ route('notificaciones.index') }}">
                                    <i style="font-size: 30px" class="fa-regular fa-calendar-check"></i>
                                    <span style="font-size: 13px;">{{ __('Calificar') }}</span></a>
                            </li>

                            <li class="nav-item dropdown" style="border-left: solid 1px rgba(0,0,0,.3);">
                                <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                    class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre><i style="font-size: 30px"
                                        class="fa-solid fa-user"></i>
                                    <span style="font-size: 13px;">
                                        {{ Auth::user()->name }}
                                    </span></a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" style="font-weight: 800; font-size: 16px"
                                    class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    ({{ Auth::user()->email }})
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li> --}}
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 custom_container">
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
    @yield('script')
</body>

</html>
