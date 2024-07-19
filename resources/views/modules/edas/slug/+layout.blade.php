@extends('modules.edas.+layout')

@section('title', 'Gestión de Edas: ' . $user->first_name . ' ' . $user->last_name)

@php
    $hasPosibleCreate = $cuser->hasPrivilege('edas:create') && $current_year->status;
@endphp

@section('layout.edas')
    <div class="text-black h-full py-2 max-sm:py-1 w-full flex-grow flex flex-col overflow-y-auto">
        <header class="space-y-3 pb-1">
            <div class="p-1">
                <div class="rounded-2xl w-fit bg-white shadow-sm">
                    <div class="border-b p-3 font-semibold tracking-tight">
                        Colaborador
                    </div>
                    <div class="p-3 px-5 flex items-center gap-4">
                        @include('commons.avatar', [
                            'src' => $user->profile,
                            'className' => 'w-28',
                            'alt' => $user->first_name . ' ' . $user->last_name,
                            'altClass' => 'text-3xl',
                        ])
                        <div>
                            <p class="font-semibold text-lg">{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="text-neutral-500">{{ $user->email }}</p>
                            @if ($user->supervisor_id)
                                <a href="/users/{{ $user->supervisor_id }}/"
                                    title="Ir al perfil de {{ $user->supervisor->first_name }} {{ $user->supervisor->last_name }}."
                                    class="flex mt-2 items-center gap-2 bg-sky-500/10 hover:bg-sky-500/20 rounded-lg p-2">
                                    @include('commons.avatar', [
                                        'src' => $user->supervisor->profile,
                                        'className' => 'w-7',
                                        'alt' =>
                                            $user->supervisor->first_name . ' ' . $user->supervisor->last_name,
                                        'altClass' => 'text-3xl',
                                    ])
                                    <div>
                                        <p class="text-xs opacity-70">Bajo supervisión de</p>
                                        <p class="text-xs font-medium text-blue-600">{{ $user->supervisor->first_name }}
                                            {{ $user->supervisor->last_name }}</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <nav class="flex items-center font-semibold overflow-x-auto text-neutral-700 gap-2.5">
                @foreach ($years as $y)
                    <a {{ request()->is('edas/' . $user->id . '/eda/' . $y->id . '*') ? 'data-state=open' : '' }}
                        href="/edas/{{ $user->id }}/eda/{{ $y->id }}"
                        class="p-1.5 px-5 border-neutral-300 data-[state=open]:border-2 data-[state=open]:border-blue-600 text-black data-[state=open]:bg-blue-100 hover:bg-blue-50 border data-[state=open]:font-medium rounded-full relative">
                        {{ $y->name }}
                    </a>
                @endforeach
            </nav>
        </header>
        @if ($eda)
            <div class="h-full flex flex-col">
                @yield('layout.edas.slug')
            </div>
        @else
            <div class="grid text-center h-full gap-2 place-content-center p-10">
                <h2 class="text-xl font-semibold tracking-tight">Eda no disponible</h2>
                <img src="/empty_filter.webp" width="200" class="mx-auto" alt="">
                <p class="text-neutral-400">Aun no se registró el eda del año {{ $current_year->name }}</p>
                @if ($current_user->hasPrivilege('edas:create'))
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
