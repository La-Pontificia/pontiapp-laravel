@extends('modules.+layout')

@section('title', 'Gestión de usuarios')

@section('content')
    @if ($cuser->hasGroup('users'))
        @yield('layout.users')
    @else
        @include('+403', [
            'message' => 'No tienes permiso para acceder a este modulo.',
        ])
    @endif
@endsection
