@extends('modules.edas.(group).+layout')

@section('title', 'Gestión de Edas')

@php
    $status = [
        [
            'value' => 'sent',
            'text' => 'Enviado',
        ],
        [
            'value' => 'approved',
            'text' => 'Aprobado',
        ],
        [
            'value' => 'closed',
            'text' => 'Cerrado',
        ],
    ];

    $hasCreate = $cuser->has('users:edas:create_all') || $cuser->isDev();
@endphp

@section('layout.group.edas')
    <div class="w-full flex flex-col overflow-y-auto">
        <div class="flex items-center pb-2">
            <button {{ !$hasCreate ? 'disabled' : '' }} data-modal-target="dialog" data-modal-toggle="dialog" class="primary">
                @svg('bx-plus', 'w-5 h-5')
                <span>Registrar</span>
            </button>
            @if ($hasCreate)
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Registrar nueva EDA
                        </header>
                        <form action="/api/edas/create-independent" method="POST" id="dialog-form"
                            class="dinamic-form body grid gap-4">
                            @include('modules.edas.form')
                        </form>

                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Registrar</button>
                        </footer>
                    </div>
                </div>
            @endif
            @if ($cuser->has('users:schedules:export') || $cuser->isDev())
                <button {{ count($edas) == 0 ? 'disabled' : '' }} data-dropdown-toggle="dropdown" class="secondary ml-auto">
                    @svg('bx-up-arrow-circle', 'w-5 h-5')
                    <span>
                        Exportar
                    </span>
                </button>
                <div id="dropdown" class="dropdown-content hidden">
                    <button data-type="excel"
                        class="p-2 hover:bg-neutral-100 export-data-users text-left w-full block rounded-md hover:bg-gray-10">
                        Excel (.xlsx)
                    </button>
                    <button data-type="json"
                        class="p-2 hover:bg-neutral-100 export-data-users text-left w-full block rounded-md hover:bg-gray-10">
                        JSON (.json)
                    </button>
                </div>
            @endif
        </div>
        <div class="flex items-center gap-2 p-3 pt-0">
            <label class="relative w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('bx-search', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('q') }}" placeholder="Filtrar edas..." type="search"
                    class="w-full pl-9 dinamic-search">
            </label>

            <select class="dinamic-select w-[140px]" name="status">
                <option value="0">Estado</option>
                @foreach ($status as $item)
                    <option {{ request()->query('status') === $item['value'] ? 'selected' : '' }}
                        value="{{ $item['value'] }}">{{ $item['text'] }}</option>
                @endforeach
            </select>

            <select class="dinamic-select w-[100px]" name="year">
                <option value="0">Año</option>
                @foreach ($years as $year)
                    <option {{ request()->query('year') === $year->id ? 'selected' : '' }} value="{{ $year->id }}">
                        {{ $year->name }}</option>
                @endforeach
            </select>
            {{-- 
            <div class="flex items-center text-nowrap line-clamp-2 gap-1 text-sm">
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
                Evaluaciones
            </div> --}}
        </div>
        <div class="flex flex-col h-full divide-y overflow-y-auto">
            @if ($cuser->has('users:edas:show') || $cuser->isDev())
                @if ($edas->isEmpty())
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @else
                    <table>
                        <thead>
                            <tr class="border-b text-sm">
                                <td class="px-2">Eda</td>
                                <td class="w-full"></td>
                                <td class="pb-2 text-center px-4">Objetivos</td>
                                <td class="pb-2 text-center px-4">Evaluaciones</td>
                                <td class="pb-2 text-center px-4"></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($edas as $eda)
                                <tr class="relative group text-sm hover:bg-neutral-100 [&>td]:p-3">
                                    <td>
                                        <a title="Ver eda" href="/edas/{{ $eda->user->id }}/eda/{{ $eda->year->id }}"
                                            class="absolute inset-0">
                                        </a>
                                        <p>{{ $eda->year->name }}</p>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @include('commons.avatar', [
                                                'src' => $eda->user->profile,
                                                'className' => 'w-8',
                                                'alt' => $eda->user->first_name . ' ' . $eda->user->last_name,
                                                'altClass' => 'text-base',
                                            ])
                                            <div class="flex-grow">
                                                <p>
                                                    {{ $eda->user->last_name . ', ' . $eda->user->first_name }}
                                                </p>
                                                <p class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
                                                    {{ $eda->user->role_position->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3">
                                        <p class="text flex-nowrap text-center">
                                            {{ count($eda->goals) }}
                                        </p>
                                    </td>
                                    <td class="px-3">
                                        <p class="text flex-nowrap text-center">
                                            {{ count($eda->evaluations->where('closed', true)) }}
                                        </p>
                                    </td>
                                    <td class="px-3">
                                        <div class="flex items-center gap-2">

                                            @if ($eda->closed)
                                                <span class="p-2 flex text-nowrap bg-red-500 text-white text-xs rounded-md">
                                                    Eda cerrado
                                                </span>
                                            @elseif ($eda->approved)
                                                <span
                                                    class="p-2 flex text-nowrap bg-blue-500 text-white text-xs rounded-md">
                                                    Objetivos aprobados
                                                </span>
                                            @elseif ($eda->sent)
                                                <span
                                                    class="p-2 flex text-nowrap bg-green-500 text-white text-xs rounded-md">
                                                    Objetivos enviados
                                                </span>
                                            @else
                                                <span
                                                    class="p-2 flex text-nowrap bg-yellow-500 text-white text-xs rounded-md">
                                                    Objetivos pendientes
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                    {{-- <td>
                                        <p class="text-nowrap">
                                            {{ $user->email }}
                                        </p>
                                    </td>
                                    <td>
                                        <div
                                            class="p-1 w-fit relative text-left bg-neutral-50 flex text-sm items-center gap-1 rounded-lg border px-2">
                                            @if ($user->supervisor_id)
                                                @include('commons.avatar', [
                                                    'src' => $user->supervisor->profile,
                                                    'className' => 'w-8',
                                                    'alt' =>
                                                        $user->supervisor->first_name .
                                                        ' ' .
                                                        $user->supervisor->last_name,
                                                    'altClass' => 'text-md',
                                                ])
                                                <div>
                                                    <p class="text-nowrap">
                                                        {{ $user->supervisor->first_name }}
                                                    </p>
                                                    <p class="text-xs font-normal text-nowrap">
                                                        {{ $user->supervisor->role_position->name }}
                                                    </p>
                                                </div>
                                            @else
                                                -
                                            @endif
                                            </button>
                                    </td>
                                    <td>
                                        <p class="rounded-full p-2 hover:bg-neutral-200 transition-colors block">
                                            @svg('bx-chevron-right', 'w-5 h-5')
                                        </p>
                                    </td> --}}
                                    <td class="px-3">
                                        <p class="text-xs text-nowrap">
                                            <span class="text-neutral-400"> Registrado el
                                                {{ $eda->created_at->format('d/m/Y') }}
                                                por
                                                {{ $eda->createdBy->first_name }}
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 py-4">
                        {!! $edas->links() !!}
                    </footer>
                @endif
            @else
                <p class="p-20 grid place-content-center text-center">
                    No tienes permisos para visualizar estos datos.
                </p>
            @endif
        </div>
    </div>
@endsection
