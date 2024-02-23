@extends('layouts.sidebar')

@section('content-sidebar')
    @php
        $hasEdas = in_array('ver_edas', $colaborador_actual->privilegios) || in_array('mis_edas', $colaborador_actual->privilegios);
    @endphp
    <div class="flex flex-col">
        <header class="h-full border rounded-3xl shadow-lg">
            <div class="w-full p-3">
                <div class="flex relative group min-w-[6rem] h-[6rem] w-[6rem] border overflow-hidden rounded-full"">
                    <img alt="{{ $colaborador->nombres }}"
                        src="{{ $colaborador->perfil ? $colaborador->perfil : '/profile-user.png' }}"
                        class="w-full h-full object-cover" />
                </div>
                {{-- <button id="upload"
                    class="bg-slate-800 hidden disabled:opacity-50 p-1 rounded-full text-white font-semibold px-3">Actualizar
                    perfil</button> --}}
                <h3 class="text-lg pt-2 font-semibold capitalize text-gray-900">
                    {{ $colaborador->nombres }}
                    {{ $colaborador->apellidos }}
                    <b>{{ $miPerfil ? 'Mi perfil' : '' }}</b>
                </h3>
                <div class="flex flex-col">
                    <div class="text-gray-500 capitalize flex gap-1">
                        {{ mb_strtolower($colaborador->cargo->puesto->nombre, 'UTF-8') }}
                        -
                        {{ mb_strtolower($colaborador->cargo->departamento->area->nombre, 'UTF-8') }}
                    </div>
                </div>
            </div>
            @if ($hasEdas)
                @include('meta.edas')
            @endif
        </header>
        @if ($hasEdas)
            <div class="w-full">
                @yield('content-meta')
            </div>
        @endif
    </div>
@endsection
