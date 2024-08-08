@extends('modules.+layout')

@section('title', 'Ajustes del sistema')

@section('content')
    @if ($cuser->hasGroup('settings'))
        @yield('layout.settings')
    @else
        @include('+403', [
            'message' => 'No tienes permiso para acceder a este modulo.',
        ])
    @endif
@endsection
