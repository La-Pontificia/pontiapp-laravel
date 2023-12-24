@extends('layouts.sidebar')


@section('content-sidebar')
    <header class="border-b flex items-center gap-4">
        {{-- <h1 class="text-xl font-bold">Reportes y estadisticas</h1> --}}
        <nav class="flex p-1 [&>a]:rounded-full [&>a]:px-4 [&>a]:py-2 text-gray-500 font-medium">
            <a class="hover:opacity-70 {{ request()->is('reportes*/edas*') ? 'text-white bg-slate-900' : '' }}"
                href="{{ route('reportes.edas') }}">Edas</a>
            <a class=" hover:opacity-70 {{ request()->is('reportes*/colaboradores*') ? 'text-white bg-slate-900' : '' }}"
                href="{{ route('reportes.colaboradores') }}">Colaboradores</a>
            <a class=" hover:opacity-70 {{ request()->is('reportes*/objetivos*') ? 'text-white bg-slate-900' : '' }}"
                href="{{ route('reportes.objetivos') }}">Objetivos</a>
        </nav>
    </header>
    @yield('content-reportes')
@endsection
