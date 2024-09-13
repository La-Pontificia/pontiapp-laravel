@extends('modules.+layout')

@section('title', 'Gestión de asistencias')

@section('content')
    <div class="flex flex-col flex-grow h-full w-full">
        @yield('layout.assists')
        <div class="p-2">
            <p class="text-xs">
                Estado del servidor de asistencias: <span id="check-server"></span>
            </p>
            <p id="error-server" class="text-xs text-red-500">

            </p>
        </div>
    </div>
@endsection
