@extends('layouts.app')

@section('title', 'Gestión de Edas: ' . $user->first_name . ' ' . $user->last_name)

@php
    $id_year = request()->route('year');
@endphp

@section('content')
    <div class="text-black h-full py-2 max-sm:py-1 w-full flex-grow flex flex-col overflow-y-auto">
        <header class="space-y-3 pb-2">
            <div>
                @include('components.users.card', ['user' => $user])
            </div>
            <nav class="flex items-center font-semibold overflow-x-auto text-neutral-700 gap-2.5">
                <h1>Edas</h1>
                @foreach ($years as $y)
                    <a {{ request()->is('edas/' . $user->id . '/eda/' . $y->id . '*') ? 'data-state=open' : '' }}
                        href="{{ route('edas.user.year', ['id_user' => $user->id, 'id_year' => $y->id]) }}"
                        class="p-1.5 px-5 border-neutral-300 data-[state=open]:border-2 data-[state=open]:border-blue-600 text-black data-[state=open]:bg-blue-100 hover:bg-blue-50 border data-[state=open]:font-medium rounded-full relative">
                        {{ $y->name }}
                    </a>
                @endforeach
            </nav>
        </header>
        @if ($eda)
            <div class="h-full overflow-y-auto px-2 flex flex-col">
                <div class="py-2 pt-0 border-b border-neutral-300">
                    <h1 class="text-lg font-semibold">Completa todas las tareas asignadas.</h1>
                    <p class=" font-normal text-sm">Eda registrado el
                        {{ \Carbon\Carbon::parse($eda->created_at)->isoFormat('LL') }} por
                        <a title="Ir al perfil de {{ $eda->createdBy->first_name }} {{ $eda->createdBy->last_name }}"
                            href="/profile/{{ $eda->createdBy->id }}" class="hover:underline text-blue-600">
                            {{ $eda->createdBy->first_name }}
                            {{ $eda->createdBy->last_name }}.
                        </a>
                    </p>
                </div>
                @yield('content-eda-user')
            </div>
        @else
            <div class="grid text-center h-full gap-2 place-content-center p-10">
                <h2 class="text-xl font-semibold tracking-tight">Eda no disponible</h2>
                <img src="/empty_filter.webp" width="200" class="mx-auto" alt="">
                <p class="text-neutral-400">Aun no se registró el eda del año {{ $current_year->name }}</p>
                @if ($current_user->hasPrivilege('create_edas'))
                    <button {{ !$hasPosibleCreate ? 'disabled' : '' }} data-id-year="{{ $current_year->id }}"
                        data-id-user="{{ $user->id }}" id="create-eda"
                        class="p-2 disabled:opacity-50 rounded-full w-fit mx-auto px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-base">
                        Registrar ahora
                    </button>
                @endif
            </div>
        @endif
    </div>
@endsection
