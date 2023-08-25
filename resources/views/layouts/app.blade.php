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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    {{-- <i class="fa-solid fa-table"></i> --}}
                    <img src="/elp.gif" style="width: 120px;" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" style="display: flex; gap: 5px">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('areas.index') }}"><i class="fa-solid fa-table"></i>
                                    {{ __('Areas') }}</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('puestos.index') }}"><i class="fa-solid fa-table"></i>
                                    {{ __('Puestos') }}</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('departamentos.index') }}"><i class="fa-solid fa-table"></i>
                                    {{ __('Departamentos') }}</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('cargos.index') }}"><i class="fa-solid fa-table"></i>
                                    {{ __('Cargos') }}</a>
                            </li>

                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('supervisores.index') }}"><i class="fa-solid fa-table"></i>
                                    {{ __('Supervisores') }}</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-weight: 800; font-size: 16px" class="nav-link"
                                    href="{{ route('colaboradores.index') }}"><i class="fa-solid fa-users"></i>
                                    {{ __('Colaboradores') }}</a>
                            </li>
                            <li class="nav-item dropdown">
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

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
    </div>
</body>

</html>
