@extends('modules.+layout')

@section('title', 'Gestión Auditoria')
@php
    $actions = [
        'create' => 'Crear',
        'update' => 'Actualizar',
        'delete' => 'Eliminar',
        'selfqualify' => 'Autoevaluar',
        'qualify' => 'Calificar',
        'close' => 'Cerrar',
        'feedback' => 'Retroalimentar',
        'sent' => 'Enviar',
        'approve' => 'Aprobar',
        'export' => 'Exportar',
    ];

    $modules = [
        'users' => 'Usuarios',
        'roles' => 'Roles',
        'events' => 'Eventos',
        'schedules' => 'Horarios',
        'assists' => 'Asistencias',
        'edas' => 'EDAs',
        'audits' => 'Auditorias',
        'maintenances' => 'Mantenimientos',
    ];

@endphp

@section('content')
    <div class="w-full mx-auto h-full overflow-y-auto flex flex-col">
        <form class="flex dinamic-form-to-params p-1 items-center flex-wrap gap-2">
            <label class="label">
                <span>Accion:</span>
                <select class="bg-white" name="action">
                    <option value="">Todos</option>
                    @foreach ($actions as $key => $value)
                        <option {{ request()->query('action') === $key ? 'selected' : '' }} value="{{ $key }}"
                            {{ request()->get('status') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="label">
                <span>Modulo:</span>
                <select class="bg-white" name="module">
                    <option value="">Todos</option>
                    @foreach ($modules as $key => $value)
                        <option {{ request()->query('module') === $key ? 'selected' : '' }} value="{{ $key }}"
                            {{ request()->get('status') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="relative mt-6 ml-auto w-[200px] max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..." type="search"
                    class="pl-9 w-full bg-white">
            </label>

            <button class="primary mt-6">
                Filtrar
            </button>

            @if ($cuser->has('audit:export') || $cuser->isDev())
                <button disabled type="button" id="export-audit" class="secondary mt-6">
                    @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                    <span>
                        Exportar
                    </span>
                </button>
            @endif
        </form>
        <div class="flex flex-col pt-2 w-full overflow-y-auto h-full">
            <div class="flex flex-col h-full overflow-y-auto">
                @if ($cuser->has('audit:show') || $cuser->isDev())
                    @if ($records->isEmpty())
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @else
                        <table>
                            <thead>
                                <tr class="border-b text-sm [&>td]:p-2">
                                    <td class="font-medium"></td>
                                    <td class="font-medium opacity-70">Título</td>
                                    <td class="font-medium opacity-70">Descripción</td>
                                    <td class="font-medium opacity-70">Path</td>
                                    <td class="font-medium opacity-70">Modulo</td>
                                    <td class="font-medium opacity-70">Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr class="relative group border-b [&>td]:hover:bg-white [&>td]:p-2">
                                        <td class="rounded-l-2xl relative">
                                            <button class="absolute inset-0" data-modal-target="dialog-{{ $record->id }}"
                                                data-modal-toggle="dialog-{{ $record->id }}"></button>
                                            <div id="dialog-{{ $record->id }}" tabindex="-1" aria-hidden="true"
                                                class="dialog hidden">
                                                <div class="content lg:max-w-lg max-w-full">
                                                    <header>
                                                        Registro de auditoria
                                                    </header>
                                                    <div id="dialog-{{ $record->id }}-form"
                                                        class="body grid overflow-y-auto">
                                                        <h2 class="font-semibold tracking-tight text-xl">
                                                            {{ $record->title }}
                                                        </h2>
                                                        <p>
                                                            {{ $record->description }}
                                                        </p>

                                                        <div class="grid gap-1 mt-3">

                                                            <p>
                                                                <span class="font-semibold">Acción:</span>
                                                                <span
                                                                    class="p-0.5 px-2 text-xs bg-green-500/10 rounded-full text-green-500 font-medium">
                                                                    {{ $actions[$record->action] }}
                                                                </span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Modulo:</span>
                                                                <span
                                                                    class="p-0.5 px-2 text-xs bg-blue-500/10 rounded-full text-blue-500 font-medium">
                                                                    {{ $modules[$record->module] }}
                                                                </span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Ip:</span>
                                                                <span>{{ $record->ip }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Os:</span>
                                                                <span>{{ $record->os }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Plataforma:</span>
                                                                <span>{{ $record->platform }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Dispositivo:</span>
                                                                <span>{{ $record->device ?? '-' }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Navegador:</span>
                                                                <span>{{ $record->browser ?? '-' }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Pais:</span>
                                                                <span>{{ $record->country ?? '-' }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Region:</span>
                                                                <span>{{ $record->region ?? '-' }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Ciudad:</span>
                                                                <span>{{ $record->city ?? '-' }}</span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Path:</span>
                                                                <span>{{ $record->path ?? '-' }}</span>
                                                            </p>

                                                            <p>
                                                                <span class="font-semibold">Regitrado:</span>
                                                                <span>
                                                                    {{ $record->created_at->diffForHumans() }} -
                                                                    {{ $record->created_at->format('d/m/Y H:i:s') }}
                                                                </span>
                                                            </p>
                                                            <p>
                                                                <span class="font-semibold">Usuario:</span>
                                                                <span>
                                                                    <a class="text-nowrap font-medium hover:underline"
                                                                        href="/users/{{ $record->user->id }}">
                                                                        {{ $record->user->names() }}
                                                                        @if ($record->user->isDev())
                                                                            <span class="text-blue-500">
                                                                                (Developer)
                                                                            </span>
                                                                        @endif
                                                                    </a>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <footer>
                                                        <button class="primary"
                                                            data-modal-hide="dialog-{{ $record->id }}">
                                                            Aceptar</button>
                                                    </footer>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @include('commons.avatar', [
                                                    'src' => $record->user->profile,
                                                    'className' => 'w-12',
                                                    'key' => $record->user->id,
                                                    'alt' => $record->user->names(),
                                                    'altClass' => 'text-xl',
                                                ])
                                                <div class="flex-grow">
                                                    <a class="text-nowrap relative font-medium hover:underline"
                                                        href="/users/{{ $record->user->id }}">
                                                        {{ $record->user->names() }}
                                                        @if ($record->user->isDev())
                                                            <span class="text-blue-500">
                                                                (Developer)
                                                            </span>
                                                        @endif
                                                    </a>
                                                    <p class="text-nowrap">
                                                        {{ $record->ip }}
                                                        |
                                                        {{ $record->os }}
                                                        |
                                                        {{ $record->platform }}
                                                        |
                                                        {{ $record->device }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                {{ $record->title }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                {{ $record->description }}
                                            </p>
                                        </td>
                                        <td>
                                            <div class="overflow-hidden">
                                                <p class="line-clamp-1">
                                                    {{ $record->path }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                @svg('fluentui-folder-globe-20', 'w-5 h-5 inline-block mr-1 opacity-60')
                                                {{ $modules[$record->module] }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                {{ $actions[$record->action] }}
                                            </p>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="text-nowrap">
                                                    {{ $record->created_at->diffForHumans() }}
                                                </p>
                                                <p class="text-nowrap text-sm opacity-70">
                                                    {{ $record->created_at->format('d/m/Y H:i:s') }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="rounded-r-2xl relative">
                                            @if ($cuser->has('audit:delete') || $cuser->isDev())
                                                <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                                    data-dropdown-toggle="dropdown-{{ $record->id }}">
                                                    @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                                                </button>
                                                <div id="dropdown-{{ $record->id }}" class="dropdown-content hidden">
                                                    <button data-atitle="¿Estás seguro de eliminar?" data-adescription=""
                                                        data-param="/api/audit/{{ $record->id }}/delete"
                                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                        Eliminar
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <footer class="px-5 py-4">
                            {!! $records->links() !!}
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
