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
        [
            'value' => 'not-sent',
            'text' => 'No enviado',
        ],
        [
            'value' => 'not-approved',
            'text' => 'No aprobado',
        ],
        [
            'value' => 'not-closed',
            'text' => 'No cerrado',
        ],
    ];

    $hasCreate = $cuser->has('edas:create_all') || $cuser->isDev();
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
            @if ($cuser->has('edas:export') || $cuser->isDev())
                {{-- <button {{ count($edas) == 0 ? 'disabled' : '' }} data-dropdown-toggle="dropdown" class="secondary ml-auto">
                    @svg('bx-up-arrow-circle', 'w-5 h-5')
                    <span>
                        Exportar
                    </span>
                </button> --}}
                <button {{ count($edas) == 0 ? 'disabled' : '' }} data-modal-target="dialog-export"
                    data-modal-toggle="dialog-export" class="secondary ml-auto">
                    @svg('bx-up-arrow-circle', 'w-5 h-5')
                    <span>Exportar</span>
                </button>
                <div id="dialog-export" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-md max-w-full">
                        <header>
                            Exportar edas
                        </header>
                        <form method="POST" id="form-export-edas" class="body grid gap-4">
                            <div class="grid grid-cols-3 gap-4">
                                <label class="flex items-center gap-1">
                                    <input type="radio" checked name="type" value="basic">
                                    <span>
                                        Básico
                                    </span>
                                </label>
                                <label class="flex items-center gap-1">
                                    <input disabled type="radio" name="type" value="advanced">
                                    <span>
                                        Avanzado
                                    </span>
                                </label>
                            </div>
                            <div class="text-sm space-y-1 flex flex-col">
                                <p class="opacity-30 grayscale">
                                    <span class="block font-semibold">Avanzado</span>
                                    Se exportarán todos lo datos de intermedio y adicionalmente se exportarán la lista de
                                    objetivos, descripciones, indicadores, etc. La lista de las evaluacionesm los
                                    cuestionarios y
                                    las respuestas. Y todas las fechas de los registros.
                                </p>
                            </div>
                        </form>
                        <footer>
                            <button data-modal-hide="dialog-export" type="button">Cancelar</button>
                            <button form="form-export-edas" id="button-export-edas" type="submit"
                                class="flex items-center gap-1">
                                @svg('bxs-file-doc', 'w-5 h-5')
                                <span>Exportar (.xlsx)</span>
                            </button>
                        </footer>
                    </div>
                </div>
            @endif
        </div>
        <div class="bg-[#ffffff] rounded-xl m-2 h-full flex flex-col shadow-md overflow-auto border">
            <form class="flex dinamic-form-to-params items-center gap-2 p-3">
                <label class="relative w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('bx-search', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('q') }}" placeholder="Filtrar edas..." type="search"
                        class="w-full pl-9">
                </label>
                <select class="w-[140px]" name="department">
                    <option value>Departamento</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <select class="w-[100px]" name="job_position">
                    <option value>Puesto</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
                <select class="w-[140px]" name="status">
                    <option value>Estado</option>
                    @foreach ($status as $item)
                        <option {{ request()->query('status') === $item['value'] ? 'selected' : '' }}
                            value="{{ $item['value'] }}">{{ $item['text'] }}</option>
                    @endforeach
                </select>
                <select class="w-[100px]" name="year">
                    <option value>Año</option>
                    @foreach ($years as $year)
                        <option {{ request()->query('year') === $year->id ? 'selected' : '' }}
                            value="{{ $year->id }}">
                            {{ $year->name }}</option>
                    @endforeach
                </select>
                <button class="primary">
                    Filtrar
                </button>
            </form>
            <div class="flex flex-col h-full  divide-y overflow-y-auto w-full ">
                @if ($cuser->has('edas:show') || $cuser->isDev())
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
                                    <td class="pb-2 text-center px-4">Cuestionarios</td>
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
                                                    <p
                                                        class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
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
                                            <p class="text flex-nowrap text-center">
                                                {{ count($eda->questionnaires) }}
                                            </p>
                                        </td>
                                        <td class="px-3">
                                            <div class="flex items-center gap-2">

                                                @if ($eda->closed)
                                                    <span
                                                        class="p-2 flex text-nowrap bg-red-500 text-white text-xs rounded-md">
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
    </div>
@endsection
