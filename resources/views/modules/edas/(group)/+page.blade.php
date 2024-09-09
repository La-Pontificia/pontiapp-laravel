@extends('modules.edas.+layout')

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

@section('layout.edas')
    <div class="w-full pt-3 flex flex-col">
        <div class="flex items-center gap-2">
            <button type="button" {{ !$hasCreate ? 'disabled' : '' }} data-modal-target="dialog" data-modal-toggle="dialog"
                class="primary">
                @svg('fluentui-document-add-28-o', 'w-5 h-5')
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
            <form class="flex flex-grow dinamic-form-to-params items-center gap-2">
                <select class="w-fit bg-white" name="year">
                    <option value>Año</option>
                    @foreach ($years as $year)
                        <option {{ request()->query('year') === $year->id ? 'selected' : '' }} value="{{ $year->id }}">
                            {{ $year->name }}</option>
                    @endforeach
                </select>
                <select class="w-fit bg-white" name="status">
                    <option value>Estado</option>
                    @foreach ($status as $item)
                        <option {{ request()->query('status') === $item['value'] ? 'selected' : '' }}
                            value="{{ $item['value'] }}">{{ $item['text'] }}</option>
                    @endforeach
                </select>
                <select class="w-fit bg-white" name="department">
                    <option value>Departamento</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <select class="w-fit bg-white" name="job_position">
                    <option value>Puesto</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
                <label class="relative ml-auto w-[200px]">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" placeholder="Filtrar edas..." name="query"
                        type="search" class="pl-9 w-full bg-white">
                </label>
                <button class="primary">
                    Filtrar
                </button>
            </form>
            @if ($cuser->has('edas:export') || $cuser->isDev())
                <button type="button" id="button-export-edas" class="secondary">
                    @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                    <span>Exportar</span>
                </button>
            @endif
        </div>
        <div class="flex flex-col h-full w-full ">
            @if ($cuser->has('edas:show') || $cuser->isDev())
                @if ($edas->isEmpty())
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @else
                    <div class="py-2 font-semibold text-lg px-2">
                        Edas registradas
                    </div>
                    <table>
                        <thead>
                            <tr class="border-b text-sm">
                                <td></td>
                                <td class="w-full"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($edas as $eda)
                                <tr class="relative group border-b [&>td]:hover:bg-white [&>td]:p-3">
                                    <td class="rounded-l-2xl">
                                        <p class="font-semibold flex items-center gap-1">
                                            @svg('fluentui-document-link-20-o', 'w-5 h-5')
                                            {{ $eda->year->name }}
                                        </p>
                                    </td>
                                    <td>
                                        <a class="absolute inset-0"
                                            href="/edas/{{ $eda->user->id }}/eda/{{ $eda->year->id }}">

                                        </a>
                                        <div class="flex items-center gap-2">
                                            @include('commons.avatar', [
                                                'src' => $eda->user->profile,
                                                'className' => 'w-12',
                                                'key' => $eda->user->id,
                                                'alt' => $eda->user->first_name . ' ' . $eda->user->last_name,
                                                'altClass' => 'text-xl',
                                            ])
                                            <div class="flex-grow">
                                                <p class="text-nowrap font-semibold">
                                                    {{ $eda->user->names() }}
                                                </p>
                                                <p class="text-nowrap text-xs">
                                                    {{ $eda->user->role_position->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/edas/{{ $eda->user->id }}/eda/{{ $eda->year->id }}/goals"
                                            class="text relative text-sm hover:underline hover:text-blue-600 text-nowrap text-center flex items-center gap-1">
                                            @svg('fluentui-text-bullet-list-square-edit-20-o', 'w-5 h-5')
                                            {{ count($eda->goals) }}
                                            {{ count($eda->goals) === 1 ? 'Objetivo' : 'Objetivos' }}
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text flex-nowrap text-center text-nowrap flex items-center gap-1 text-sm">
                                            @svg('fluentui-task-list-square-person-20-o', 'w-5 h-5')
                                            {{ count($eda->evaluations->where('closed', true)) }}
                                            {{ count($eda->evaluations->where('closed', true)) === 1 ? 'Evaluación' : 'Evaluaciones' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text text-nowrap text-sm text-center">
                                            {{ count($eda->questionnaires) }}
                                            {{ count($eda->questionnaires) === 1 ? 'Cuestionario' : 'Cuestionarios' }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <span class="flex text-nowrap gap-2 text-sm rounded-lg">
                                                @if ($eda->closed)
                                                    @svg('fluentui-checkmark-circle-12', 'w-5 h-5 text-green-500')
                                                    Cerrado
                                                @elseif ($eda->approved)
                                                    @svg('fluentui-checkmark-circle-12', 'w-5 h-5 text-blue-500')
                                                    Objetivos aprobados
                                                @elseif ($eda->sent)
                                                    @svg('fluentui-send-clock-20', 'w-5 h-5 text-purple-500 -rotate-12')
                                                    Objetivos enviados
                                                @else
                                                    @svg('fluentui-arrow-sync-circle-16', 'w-5 h-5 text-yellow-500')
                                                    Objetivos pendientes
                                                @endif
                                            </span>

                                        </div>
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
