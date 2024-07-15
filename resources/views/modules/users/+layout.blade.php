@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')
    <div class="text-black w-full flex-grow flex overflow-y-auto">
        @include('components.modules.users.sidebar')
        <div class="w-full overflow-y-auto flex flex-col h-full">
            @yield('layout.users')
        </div>
    </div>
@endsection
