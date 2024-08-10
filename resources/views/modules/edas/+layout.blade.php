@extends('modules.+layout')

@section('title', 'Gestión de usuarios')

@section('content')
    @if ($cuser->hasGroup('edas') || $cuser->isDev())
        @yield('layout.edas')
    @else
        @include('+403', [
            'message' => 'No tienes permiso para acceder a este modulo.',
        ])
    @endif
@endsection
