@extends('layouts.app')

@section('content')
    <div class="custom_container">
        <div class="" style="width: 100%; justify-content: center;">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
                style="position: sticky; top: 100px; z-index: 10; border-radius: 10px; padding: 10px;">
                <div class="collapse navbar-collapse" style="flex-grow: 0;" id="navbarSupportedContent2"
                    style="justify-content: start; padding: 0 10px;">
                    <ul class="navbar-nav ms-auto" style="display: flex; gap: 20px; align-items: center;">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                            @endif
                        @else
                            <li class="nav-item" style="">
                                <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                    class="nav-link {{ request()->is('accesos*') ? 'text-primary' : '' }}"
                                    href="{{ route('accesos.index') }}"><i style="font-size: 30px"
                                        class="fa-solid fa-universal-access"></i>
                                    <span style="font-size: 13px;">{{ __('Acessos') }}</span></a>
                            </li>
                            @if ($accesos->contains('modulo', 'Departamentos'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('departamentos*') ? 'text-primary' : '' }}"
                                        href="{{ route('departamentos.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-house-flag"></i>
                                        <span style="font-size: 13px;">{{ __('Departamentos') }}</span></a>
                                </li>
                            @endif

                            @if ($accesos->contains('modulo', 'Areas'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('areas*') ? 'text-primary' : '' }}"
                                        href="{{ route('areas.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-table"></i>
                                        <span style="font-size: 13px;">{{ __('Areas') }}</span></a>
                                </li>
                            @endif
                            @if ($accesos->contains('modulo', 'Puestos'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('puestos*') ? 'text-primary' : '' }}"
                                        href="{{ route('puestos.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-table"></i>
                                        <span style="font-size: 13px;">{{ __('Puestos') }}</span></a>
                                </li>
                            @endif

                            @if ($accesos->contains('modulo', 'Cargos'))
                                <li class="nav-item">
                                    <a style="font-weight: 800; font-size: 16px; display: flex; flex-direction: column; justify-content: center; align-items: center;"
                                        class="nav-link {{ request()->is('cargos*') ? 'text-primary' : '' }}"
                                        href="{{ route('cargos.index') }}"><i style="font-size: 30px"
                                            class="fa-solid fa-address-card"></i>
                                        <span style="font-size: 13px;">{{ __('Cargos') }}</span></a>
                                </li>
                            @endif


                        @endguest
                    </ul>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <div class="py-4 ">
                @yield('content-2')
            </div>
        </div>
    </div>
@endsection
