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
        <div class="text-black p-1 h-full max-sm:py-1 w-full flex-grow flex overflow-y-auto gap-2">
            <aside class="space-y-3 min-w-[330px] max-lg:min-w-max pb-1 bg-white border shadow-sm rounded-xl">
                <nav class="flex flex-col overflow-x-auto text-neutral-700">
                    <div class="p-3 border-b flex items-center gap-2">
                        @include('commons.avatar', [
                            'src' => $edauser->profile,
                            'key' => $edauser->id,
                            'className' => 'w-10 max-lg:mx-auto',
                            'alt' => $edauser->first_name . ' ' . $edauser->last_name,
                            'altClass' => 'text-base',
                        ])
                        <div class="text-sm max-lg:hidden">
                            <p class="font-semibold tracking-tight  overflow-hidden text-ellipsis text-nowrap">
                                {{ $edauser->names() }}</p>
                            <p class="text-neutral-500 text-xs">{{ $edauser->role_position->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col p-2">
                        <p class="text-sm font-medium p-2 max-lg:hidden">Edas</p>
                        @foreach ($years as $y)
                            <a {{ request()->is('edas/' . $edauser->id . '/eda/' . $y->id . '*') ? 'data-active' : '' }}
                                href="/edas/{{ $edauser->id }}/eda/{{ $y->id }}"
                                class="p-2.5 px-3.5 flex max-lg:w-fit w-full text-sm items-center hover:bg-stone-50 gap-2 data-[active]:bg-stone-100 data-[active]:text-blue-700 font-medium rounded-lg">
                                @svg(request()->is('edas/' . $edauser->id . '/eda/' . $y->id . '*') ? 'fluentui-folder-20' : 'fluentui-folder-20-o', 'w-5 h-5')
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
                                @svg('fluentui-folder-20-o', 'w-5 h-5')
                                {{ $current_year->name }}
                            </a>
                            @if ($title)
                                <div class="mx-1">
                                    @svg('fluentui-chevron-right-28', 'w-3 h-3 text-neutral-700 opacity-50')
                                </div>
                                <div class="flex items-center gap-1">
                                    @svg($title === 'Objetivos' ? 'fluentui-text-bullet-list-square-edit-20-o' : 'fluentui-text-bullet-list-square-edit-20-o', 'w-5 h-5')
                                    @yield('title_eda')
                                </div>
                            @endif
                        </div>
                        @if (!$title)
                            <div class="flex items-center gap-2 pr-2">
                                <button class="relative" data-dropdown-toggle="dropdown">
                                    @svg('fluentui-more-horizontal-16-o', 'w-5 h-5')
                                </button>

                                <div id="dropdown"
                                    class="z-10 hidden bg-white border divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                    {{-- @if ($cuser->has('edas:export') || $cuser->isDev())
                                        <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el rol?"
                                            data-adescription="No podrás deshacer esta acción." 
                                            data-param="/api/user-roles/delete/"
                                            class="p-2 text-sm font-normal dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md">
                                            Exportar EDA
                                        </button>
                                    @endif --}}
                                    @if ($cuser->isDev())
                                        <button data-alertvariant="warning" data-atitle="¿Estás seguro de reiniciar el eda?"
                                            data-adescription="Todos los objetivos y cuestionarios serán eliminados. No podrás deshacer esta acción."
                                            data-param="/api/edas/{{ $eda->id }}/restart"
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
                        <h2 class="tracking-tight font-semibold text-lg">Eda no disponible</h2>
                        <p class="text-sm opacity-70">Aun no se registró el eda del año {{ $current_year->name }}</p>
                        @if ($hasPosibleCreate)
                            <button data-id-year="{{ $current_year->id }}"
                                data-param="/api/edas/create/{{ $current_year->id }}/user/{{ $edauser->id }}"
                                data-atitle="¿Estás seguro de crear el eda?"
                                data-adescription="Esta acción quedará registrada. No podrás deshacer esta acción."
                                class="primary dinamic-alert mx-auto mt-2">
                                @svg('fluentui-folder-add-20-o', 'w-5 h-5')
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
