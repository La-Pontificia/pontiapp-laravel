@extends('layouts.sidebar')


@section('content-sidebar')
    @php
        $hasAccess = in_array('reportes', $colaborador_actual->privilegios);
    @endphp
    @if (!$hasAccess)
        <script>
            window.location = "/";
        </script>
    @else
        <header class="border-b flex items-center gap-4">
            <nav class="flex p-1 [&>a]:rounded-full [&>a]:px-4 [&>a]:py-2 text-gray-500 font-medium">
                <a class="hover:opacity-70 {{ request()->is('reportes*/edas*') ? 'text-white bg-slate-900' : '' }}"
                    href="{{ route('reportes.edas') }}">Edas</a>
                <a class=" hover:opacity-70 {{ request()->is('reportes*/colaboradores*') ? 'text-white bg-slate-900' : '' }}"
                    href="{{ route('reportes.colaboradores') }}">Colaboradores</a>

            </nav>
        </header>
        @yield('content-reportes')
    @endif
@endsection
