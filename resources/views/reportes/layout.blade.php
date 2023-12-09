@extends('layouts.sidebar')

@section('content-sidebar')
    <header class="border-b flex items-center gap-4">
        <h1 class="text-xl font-bold">Reportes y estadisticas</h1>
        <nav class="flex gap-2 [&>a]:p-2 text-gray-500 font-medium">
            <a class="{{ request()->is('reportes') ? 'text-gray-900 bg-gray-200' : '' }}"
                href="{{ route('reportes.index') }}">Dashboard</a>
            <a class="{{ request()->is('reportes*/objetivos*') ? 'text-gray-900 bg-gray-200' : '' }}"
                href="{{ route('reportes.objetivos') }}">Objetivos</a>
        </nav>
    </header>
    @yield('content-reportes')
@endsection
