@extends('layouts.app')

@section('title', 'Gestión de Edas: ' . $user->first_name . ' ' . $user->last_name)

@php
    $id_year = request()->route('year');
@endphp

@section('content')
    <div class="text-black h-full py-2 max-sm:py-1 w-full flex-grow flex flex-col overflow-y-auto">
        <header class="space-y-4 mb-3">
            <div>
                <h2 class="text-xl text-neutral-700 tracking-tight font-semibold pb-3">Colaborador</h2>
                <div class="bg-white w-fit max-sm:w-full rounded-xl border border-neutral-100">
                    <div class="border-b p-2 px-3">
                        <p class="text-xl">
                            <a title="Ir al perfil de {{ $user->first_name }} {{ $user->last_name }}"
                                href="/profile/{{ $user->id }}" class="hover:underline">
                                <span>{{ ucfirst(strtolower(explode(' ', $user->first_name)[0])) }}</span>
                                <span>{{ ucfirst(strtolower(explode(' ', $user->last_name)[0])) }}</span>
                            </a>
                        </p>
                    </div>
                    <div class="flex w-fit items-center gap-6 p-3">
                        @include('commons.avatar', [
                            'src' => $user->profile,
                            'className' => 'w-28 max-sm:w-14',
                            'alt' => $user->first_name . ' ' . $user->last_name,
                            'altClass' => 'text-2xl',
                        ])
                        <div class="flex flex-col gap-1">

                            <p class="font-normal text-neutral-600">
                                {{ $user->role_position->name }} • {{ $user->role_position->department->name }}
                            </p>
                            <p class="font-normal text-neutral-600">
                                <a title="Ir al perfil de {{ $user->first_name }} {{ $user->last_name }}"
                                    href="/profile/{{ $user->id }}" class="hover:underline text-blue-600">
                                    Ver perfil
                                </a>
                            </p>

                            @if ($user->id_supervisor)
                                <p class="text-neutral-600 max-sm:hidden inline-flex items-center gap-2">
                                    Supervisado por:
                                    <a title="Ir al perfil de {{ $user->supervisor->first_name }} {{ $user->supervisor->last_name }}"
                                        href="/profile/"
                                        class="text-blue-700 inline-flex gap-1 items-center hover:underline">

                                        {{ $user->supervisor->last_name }},
                                        {{ $user->supervisor->first_name }}
                                    </a>
                                </p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <nav class="flex items-center font-semibold overflow-x-auto text-neutral-700 gap-2.5">
                <h1>Edas</h1>
                @foreach ($years as $year)
                    <a {{ request()->is('edas/' . $user->id . '/eda/' . $year->id . '*') ? 'data-state=open' : '' }}
                        href="{{ route('edas.user.eda', ['id_user' => $user->id, 'year' => $year->id]) }}"
                        class="p-1.5 px-5 border-neutral-300 data-[state=open]:border-2 data-[state=open]:border-blue-600 text-black data-[state=open]:bg-blue-100 hover:bg-blue-50 border data-[state=open]:font-medium rounded-full relative">
                        {{ $year->name }}

                    </a>
                @endforeach
            </nav>
        </header>
        @if ($eda)
            <div class="h-full overflow-y-auto bg-white border rounded-xl">
                @yield('content-eda-user')
            </div>
        @else
            <div class="grid text-center h-full gap-2 place-content-center p-10">
                <h2 class="text-xl font-semibold tracking-tight">Eda no disponible</h2>
                <img src="/empty_filter.webp" width="200" class="mx-auto" alt="">
                <p class="text-neutral-400">Aun no se registró el eda del año {{ $year->name }}</p>
                @if ($current_user->hasPrivilege('create_edas'))
                    <button {{ !$isPosibleCreateEda ? 'disabled' : '' }} data-id-year="{{ $id_year }}"
                        data-id-user="{{ $user->id }}" id="create-eda"
                        class="p-2 disabled:opacity-50 rounded-full w-fit mx-auto px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-base">
                        Registrar ahora
                    </button>
                @endif
            </div>
        @endif
    </div>
@endsection