@extends('modules.+layout')

@section('title', 'Gestión de usuarios')

@section('content')
    {{-- <div class="text-black w-full flex-grow flex overflowy-auto">
        @include('modules.users.sidebar')
        <div class="w-full overflow-auto flex flex-col h-full">
            @yield('layout.users')
        </div>
    </div> --}}
    @yield('layout.users')
@endsection
