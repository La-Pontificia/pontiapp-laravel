@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')
    <div class="text-black w-full flex-grow flex overflow-auto">
        @include('modules.users.sidebar')
        <div class="w-full overflow-auto flex flex-col h-full">
            @yield('layout.users')
        </div>
    </div>
@endsection
