@extends('modules.edas.+layout')

@php
    $edauser = isset($eda) ? $eda->user : $user;
@endphp

@section('title', 'Gestión de Edas: ' . $edauser->first_name . ' ' . $edauser->last_name)

@php
    $hassAcces =
        $edauser->supervisor_id === $cuser->id ||
        $cuser->has('edas:show_all') ||
        $cuser->id == $edauser->id ||
        $cuser->isDev();

    $hasPosibleCreate =
        $cuser->has('edas:create') || ($cuser->has('edas:create_all') && $current_year->status) || $cuser->isDev();

    $title = trim($__env->yieldContent('title_eda'));
@endphp

@section('layout.edas')
    @if ($hassAcces)
        <div class="text-black h-full max-sm:py-1 w-full flex-grow flex overflow-y-auto gap-2">
            <aside class="space-y-3 min-w-[300px] max-xl:min-w-max pb-1 bg-neutral-100 border shadow-sm rounded-xl">
                <nav class="flex flex-col overflow-x-auto text-neutral-700">
                    <div class="p-2 border-b flex items-center gap-2">
                        @include('commons.avatar', [
                            'src' => $edauser->profile,
                            'className' => 'w-8 max-xl:mx-auto',
                            'alt' => $edauser->first_name . ' ' . $edauser->last_name,
                            'altClass' => 'text-lg',
                        ])
                        <div class="text-sm max-xl:hidden">
                            <p class="font-semibold tracking-tight  overflow-hidden text-ellipsis text-nowrap">
                                {{ $edauser->first_name }}
                                {{ $edauser->last_name }}</p>
                            <p class="text-neutral-500 text-xs">{{ $edauser->role_position->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-1">
                        <p class="text-xs font-medium opacity-70 p-2 max-lg:hidden">Edas disponibles</p>
                        @foreach ($years as $y)
                            <a {{ request()->is('edas/' . $edauser->id . '/eda/' . $y->id . '*') ? 'data-active' : '' }}
                                href="/edas/{{ $edauser->id }}/eda/{{ $y->id }}"
                                class="p-2.5 px-3.5 flex max-xl:w-fit w-full text-sm items-center gap-2 hover:bg-white data-[active]:bg-white data-[active]:border data-[active]:text-blue-700 font-medium rounded-lg">
                                <img src="/sheet.png" class="w-5" alt="">
                                {{ $y->name }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </aside>
            <div class="h-full border relative flex flex-col w-full bg-[#ffffff] rounded-xl shadow-md overflow-auto">
                @if ($eda)
                    <nav class="p-2 pb-1 font-medium text-sm gap-4 flex items-center w-full">
                        <div class="flex items-center flex-grow">
                            <a href="/edas/{{ $edauser->id }}/eda/{{ $current_year->id }}"
                                class="flex hover:bg-slate-100 p-1 rounded-md items-center gap-1">
                                <img src="/sheet.png" class="w-5">
                                {{ $current_year->name }}
                            </a>
                            @if ($title)
                                <div>
                                    @svg('heroicon-s-chevron-right', [
                                        'class' => 'w-3 h-3 text-neutral-700',
                                    ])
                                </div>
                                <div class="flex items-center gap-1">
                                    <img src="{{ $title === 'Objetivos' ? '/pen.png' : ($title === 'Cuestionario anual' ? '/idea.png' : '/sheet-pen.png') }}"
                                        class="w-4">
                                    @yield('title_eda')
                                </div>
                            @endif
                        </div>
                        @if (!$title)
                            <div class="flex items-center gap-2 pr-2">
                                <button class="opacity-60 relative hover:opacity-100" data-dropdown-toggle="dropdown">
                                    @svg('heroicon-s-ellipsis-horizontal', [
                                        'class' => 'w-5 h-5',
                                    ])
                                </button>

                                <div id="dropdown"
                                    class="z-10 hidden bg-white border divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                    @if ($cuser->has('edas:export') || $cuser->isDev())
                                        <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el rol?"
                                            data-adescription="No podrás deshacer esta acción." {{-- data-param="/api/user-roles/delete/" --}}
                                            class="p-2 text-sm font-normal dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md">
                                            Exportar EDA
                                        </button>
                                    @endif
                                    @if ($cuser->isDev())
                                        <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el rol?"
                                            data-adescription="No podrás deshacer esta acción." {{-- data-param="/api/user-roles/delete/" --}}
                                            class="p-2 text-sm font-normal dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md text-red-600">
                                            Reiniciar EDA
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </nav>
                    @yield('layout.edas.slug')
                @else
                    <div class="grid text-center h-full text-sm w-full place-content-center p-10">
                        <img src="/empty-meetingList.webp" width="140" class="mx-auto" alt="">
                        <h2 class="tracking-tight font-semibold">Eda no disponible</h2>
                        <p class="text-xs">Aun no se registró el eda del año {{ $current_year->name }}</p>
                        @if ($hasPosibleCreate)
                            <button data-id-year="{{ $current_year->id }}"
                                data-param="/api/edas/create/{{ $current_year->id }}/user/{{ $edauser->id }}"
                                data-atitle="¿Estás seguro de crear el eda?"
                                data-adescription="Esta acción quedará registrada. No podrás deshacer esta acción."
                                class="p-1.5 flex items-center gap-2 dinamic-alert shadow-md shadow-blue-500/40 disabled:opacity-50 mt-4 rounded-full w-fit mx-auto px-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm">
                                @svg('heroicon-s-plus-circle', [
                                    'class' => 'w-5 h-5',
                                ])
                                Registrar ahora
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @else
        @include('+403', [
            'message' => 'No tienes permisos para ver este eda.',
        ])
    @endif
@endsection
