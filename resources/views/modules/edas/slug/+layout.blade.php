@extends('modules.edas.+layout')

@section('title', 'Gestión de Edas: ' . $user->first_name . ' ' . $user->last_name)

@php
    $hasPosibleCreate = $cuser->hasPrivilege('edas:create') && $current_year->status;
    $hassAcces =
        $user->supervisor_id === $cuser->id || $cuser->hasPrivilege('edas:view_all') || $cuser->id == $user->id;

    $hasCreate =
        $cuser->hasPrivilege('edas:create_all') ||
        ($cuser->hasPrivilege('edas:create_my') && $user->id == $cuser->id) ||
        ($cuser->hasPrivilege('edas:create') && $user->supervisor_id == $cuser->id);
@endphp

@section('layout.edas')
    @if ($hassAcces)
        <div class="text-black h-full py-2 max-sm:py-1 w-full flex-grow flex overflow-y-auto gap-4">
            <aside class="space-y-3 min-w-[250px] pb-1 bg-[#f5f7fc] shadow-sm rounded-xl">
                <nav class="flex flex-col overflow-x-auto text-neutral-700">
                    <div class="p-2 border-b flex items-center gap-2">
                        @include('commons.avatar', [
                            'src' => $user->profile,
                            'className' => 'w-8',
                            'alt' => $user->first_name . ' ' . $user->last_name,
                            'altClass' => 'text-lg',
                        ])
                        <div class="text-sm">
                            <p class="font-semibold tracking-tight">{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="text-neutral-500 text-xs">{{ $user->role_position->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-1">
                        @foreach ($years as $y)
                            <a {{ request()->is('edas/' . $user->id . '/eda/' . $y->id . '*') ? 'data-active' : '' }}
                                href="/edas/{{ $user->id }}/eda/{{ $y->id }}"
                                class="p-2 px-3 flex text-sm items-center gap-2 hover:bg-neutral-200/60 data-[active]:bg-white data-[active]:text-blue-700 font-medium rounded-lg">
                                <img src="/sheet.png" class="w-5" alt="">
                                {{ $y->name }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </aside>
            @if ($eda)
                <div class="h-full flex flex-col w-full overflow-auto">
                    @yield('layout.edas.slug')
                </div>
            @else
                <div class="grid text-center h-full text-sm w-full place-content-center p-10">
                    <img src="/empty_filter.webp" width="100" class="mx-auto" alt="">
                    <h2 class="tracking-tight font-semibold">Eda no disponible</h2>
                    <p class="text-xs">Aun no se registró el eda del año {{ $current_year->name }}</p>
                    @if ($hasCreate)
                        <button {{ !$hasPosibleCreate ? 'disabled' : '' }} data-id-year="{{ $current_year->id }}"
                            data-id-user="{{ $user->id }}" id="create-eda"
                            class="p-2 flex items-center gap-2 disabled:opacity-50 mt-4 rounded-full w-fit mx-auto px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm">
                            @svg('heroicon-s-plus-circle', [
                                'class' => 'w-5 h-5',
                            ])
                            Registrar ahora
                        </button>
                    @endif
                </div>
            @endif
        </div>
    @else
        @include('+403', [
            'message' => 'No tienes permisos para ver este eda.',
        ])
    @endif
@endsection
