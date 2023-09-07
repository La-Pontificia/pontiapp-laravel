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
<<<<<<< HEAD
    {{-- <link rel="stylesheet" href="resources/css/app.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
=======
    <link rel="stylesheet" href="resources/css/app.css">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cerulean/bootstrap.min.css"
        integrity="sha384-3fdgwJw17Bi87e1QQ4fsLn4rUFqWw//KU0g8TvV6quvahISRewev6/EocKNuJmEw" crossorigin="anonymous"> --}}
>>>>>>> 349c5a7f32edb3ecfa9dc547375f820fa5570329

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/simplex/bootstrap.min.css"
        integrity="sha384-FYrl2Nk72fpV6+l3Bymt1zZhnQFK75ipDqPXK0sOR0f/zeOSZ45/tKlsKucQyjSp" crossorigin="anonymous">

  {{-- //linea 23 eliminar dasboard// --}}
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
<<<<<<< HEAD
    <div id="app">
        <nav style="position: sticky; top: 0; z-index: 999;"
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="custom_container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    
                    <img src="/elp.gif" style="width: 140px;" alt="">
=======
    <div style="display: flex;" id="app">
        <nav style="position: fixed; top: 0; z-index: 999; width: 250px;"
            class=" navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="" style="display: flex; flex-direction: column; height: 100svh; width: 100%;">
                <a class="" style="" href="{{ url('/') }}">
                    <span style="display: grid; width: 100%;">
                        <img src="/elp.gif" style="width: 140px; margin: 0 auto;" alt="">
                    </span>
>>>>>>> 349c5a7f32edb3ecfa9dc547375f820fa5570329
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                

                <ul class=""
                    style="display: flex; padding: 10px; list-style: none; height: 100%; flex-direction: column; gap: 4px;">
                    <!-- Authentication Links -->

                    @guest
                        @if (Route::has('login'))
                            <li class="">
                                <a class="nav-link font-semibold text-xl" class="font-semibold"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); background-color: rgb(209, 209, 209);"
                                class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre><i style="font-size: 30px"
                                    class="fa-solid fa-user"></i>
                                <span style="font-size: 13px;">
                                    {{ Auth::user()->name }}
                                </span>
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
                        <li class="">
                            <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('objetivos*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                class="nav-link {{ request()->is('objetivos*') ? '' : '' }}"
                                href="{{ route('objetivos.index') }}"><i style="font-size: 25px"
                                    class="fa-solid fa-list-check"></i>
                                <span style="font-size: 15px;">{{ __('Mis Objetivos') }}</span></a>
                        </li>

                        @if ($accesos->contains('modulo', 'Colaboradores'))
                            <li class="">
                                <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('colaboradores*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                    class="nav-link {{ request()->is('objetivos*') ? '' : '' }}"
                                    href="{{ route('colaboradores.index') }}"><i style="font-size: 25px"
                                        class="fa-solid fa-users"></i>
                                    <span style="font-size: 15px;">{{ __('Colaboradores') }}</span></a>
                            </li>
                        @endif

                        @if ($accesos->contains('modulo', 'Supervisores'))
                            <li class="">
                                <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('supervisores*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                    class="nav-link" href="{{ route('supervisores.index') }}"><i style="font-size: 25px"
                                        class="fa-solid fa-user-tie"></i>
                                    <span style="font-size: 15px;">{{ __('Supervisores') }}</span></a>
                            </li>
                        @endif

                        <li class="">
                            <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('calificaciones*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                class="nav-link {{ request()->is('objetivos*') ? '' : '' }}"
                                href="{{ route('calificaciones.index') }}"><i style="font-size: 25px"
                                    class="fa-regular fa-calendar-check"></i>
                                <span style="font-size: 15px;">{{ __('Calificar') }}</span></a>
                        </li>

                        <ul class=""
                            style="display: flex; list-style: none; border-radius: 10px; box-shadow: 0 0 20px 1px rgba(0,0,0,.1); padding: 5px; flex-direction: column; border: solid 1px rgba(184, 184, 184, 0.369); gap: 5px;">
                            @guest
                            @else
                                @if ($accesos->contains('modulo', 'Accesos'))
                                    <li class="">
                                        <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('accesos*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                            class="nav-link" href="{{ route('accesos.index') }}"><i style="font-size: 25px"
                                                class="fa-solid fa-universal-access"></i>
                                            <span style="font-size: 15px;">{{ __('Acessos') }}</span></a>
                                    </li>
                                @endif

                                @if ($accesos->contains('modulo', 'Departamentos'))
                                    <li class="">
                                        <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('departamentos*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                            class="nav-link" href="{{ route('departamentos.index') }}"><i
                                                style="font-size: 25px" class="fa-solid fa-house-flag"></i>

                                            <span style="font-size: 15px;">{{ __('Departamentos') }}</span></a>
                                    </li>
                                @endif

                                @if ($accesos->contains('modulo', 'Areas'))
                                    <li class="">
                                        <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('areas*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                            class="nav-link" href="{{ route('areas.index') }}"><i style="font-size: 25px"
                                                class="fa-solid fa-table"></i>
                                            <span style="font-size: 15px;">{{ __('Areas') }}</span></a>
                                    </li>
                                @endif

                                @if ($accesos->contains('modulo', 'Puestos'))
                                    <li class="">
                                        <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(89, 89, 89); {{ request()->is('puestos*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                            class="nav-link" href="{{ route('puestos.index') }}"><i style="font-size: 25px"
                                                class="fa-solid fa-table"></i>
                                            <span style="font-size: 15px;">{{ __('Puestos') }}</span></a>
                                    </li>
                                @endif

                                @if ($accesos->contains('modulo', 'Cargos'))
                                    <li class="">
                                        <a style="font-weight: 500; display: flex; gap: 10px; align-items: center; padding: 10px; border-radius: 10px; color: rgb(24, 56, 216); {{ request()->is('cargos*') ? 'background-color: rgb(0, 68, 255); color: white;' : '' }}"
                                            class="nav-link" href="{{ route('cargos.index') }}"><i style="font-size: 25px"
                                                class="fa-solid fa-address-card"></i>
                                            <span style="font-size: 15px;">{{ __('Cargos') }}</span></a>
                                    </li>
                                @endif


                            @endguest
                        </ul>


                    @endguest
                </ul>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                </div>
            </div>
        </nav>
        <main class="py-4 custom_container" style="padding-left: 250px">
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
