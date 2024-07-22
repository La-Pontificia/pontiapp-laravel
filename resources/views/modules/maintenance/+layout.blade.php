@extends('modules.+layout')

@section('title', 'Mantenimiento del sistema')

@section('content')
    @if ($cuser->hasPrivilege('maintenance'))
        @yield('layout.maintenance')
    @else
        @include('+403', [
            'message' => 'No tienes permiso para acceder a este modulo.',
        ])
    @endif
@endsection
