@extends('modules.tickets.+layout')

@section('title', 'Ajustes Tickets')

@section('layout.tickets')
    <div class="flex flex-col flex-grow p-2">
        @include('modules.tickets.settings.header')
        @yield('layout.tickets.settings')
    </div>
@endsection
