@extends('modules.tickets.+layout')

@section('title', 'Registro de Ticket')


@section('layout.tickets')
    <div class="flex flex-col flex-grow gap-3 p-2">
        @include('modules.tickets.create.header')
        @yield('layout.tickets.create')
    </div>
@endsection
