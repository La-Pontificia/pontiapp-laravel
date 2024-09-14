@extends('modules.users.+layout')

@section('title', 'Gestión de usuarios')

@php
    $status = [
        [
            'value' => '',
            'text' => 'Todos',
        ],
        [
            'value' => 'actives',
            'text' => 'Activos',
        ],
        [
            'value' => 'inactives',
            'text' => 'Inactivos',
        ],
    ];

@endphp

@section('layout.users')
    <template id="item-supervisor-template">
        <button title="Seleccionar supervisor"
            class="flex w-full disabled:opacity-50 disabled:pointer-events-none text-left items-center gap-2 p-2 rounded-lg hover:bg-neutral-200">
            <div class="bg-neutral-300 overflow-hidden rounded-full w-8 h-8 aspect-square">
                <img src="" class="object-cover w-full h-full" alt="">
            </div>
            <div class="text-sm">
                <p class="result-title"></p>
                <p class="text-xs result-email"></p>
            </div>
        </button>
    </template>

    <div class="w-full mx-auto h-full overflow-y-auto flex flex-col">
        <form class="flex dinamic-form-to-params p-1 items-center gap-2">
            @if ($cuser->has('users:create') || $cuser->isDev())
                <a href="/users/create" class="primary mt-6">
                    @svg('fluentui-person-add-20-o', 'w-5 h-5')
                    <span>Nuevo</span>
                </a>
            @endif

            <label class="label">
                <span>Estado:</span>
                <select class="bg-white" name="status">
                    @foreach ($status as $item)
                        <option {{ request()->query('status') === $item['value'] ? 'selected' : '' }}
                            value="{{ $item['value'] }}">{{ $item['text'] }}</option>
                    @endforeach
                </select>
            </label>

            <label class="label">
                <span>Rol</span>
                <select class="w-fit bg-white" name="role">
                    <option value="" selected disabled>Todos</option>
                    @foreach ($user_roles as $role)
                        <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                            {{ $role->title }}</option>
                    @endforeach
                </select>
            </label>

            <label class="label">
                <span>
                    Departamento
                </span>
                <select class="w-fit bg-white" name="department">
                    <option value="" disabled selected>Todos</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="label">
                <span>
                    Puesto
                </span>
                <select class="w-fit bg-white" name="job_position">
                    <option value="" disabled selected>Todos</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="relative mt-6 ml-auto w-[200px] max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar usuarios..."
                    type="search" class="pl-9 w-full bg-white">
            </label>

            <button class="primary mt-6">
                Filtrar
            </button>

            @if ($cuser->has('users:export') || $cuser->isDev())
                <button type="button" id="export-users" class="secondary mt-6">
                    @svg('fluentui-document-table-arrow-right-20-o', 'w-5 h-5')
                    <span>
                        Exportar
                    </span>
                </button>
            @endif
        </form>
        <div class="flex flex-col pt-2 w-full overflow-y-auto h-full">
            <div class="flex flex-col h-full overflow-y-auto">
                @if ($cuser->has('users:show') || $cuser->isDev())
                    @if ($users->isEmpty())
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @else
                        <table>
                            <thead>
                                <tr class="border-b text-sm">
                                    <td class="w-full"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="relative group border-b [&>td]:hover:bg-white [&>td]:p-3">
                                        <td class="rounded-l-2xl">
                                            <a class="absolute inset-0" href="/users/{{ $user->id }}">

                                            </a>
                                            <div class="flex items-center gap-2">
                                                @include('commons.avatar', [
                                                    'src' => $user->profile,
                                                    'className' => 'w-12',
                                                    'key' => $user->id,
                                                    'alt' => $user->names(),
                                                    'altClass' => 'text-xl',
                                                ])
                                                <div class="flex-grow">
                                                    <p class="text-nowrap">
                                                        {{ $user->last_name . ', ' . $user->first_name }}
                                                        @if ($user->isDev())
                                                            <span class="text-blue-500">
                                                                (Developer)
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="{{ $user->status ? 'bg-green-400' : 'bg-red-400' }} w-2 aspect-square rounded-full">
                                                </span>
                                                {{ $user->status ? 'Activo' : 'Inactivo' }}
                                            </div>
                                        </td>
                                        <td>
                                            <p
                                                class="text-nowrap bg-white w-fit shadow-sm group-hover:shadow-lg p-3 rounded-lg flex items-center">
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-nowrap text-sm font-medium flex items-center gap-1">
                                                @svg('fluentui-person-circle-24-o', 'w-5 h-5')
                                                {{ $user->role->title }}
                                            </p>
                                        </td>

                                        <td>
                                            @if ($user->supervisor)
                                                <div class="flex items-center gap-2">
                                                    @includeIf('commons.avatar', [
                                                        'src' => $user->supervisor->profile,
                                                        'className' => 'w-12',
                                                        'key' => $user->supervisor->id,
                                                        'alt' =>
                                                            $user->supervisor->first_name .
                                                            ' ' .
                                                            $user->supervisor->last_name,
                                                        'altClass' => 'text-lg',
                                                    ])
                                                    <div>
                                                        <p class="text-xs opacity-60">
                                                            Bajo la supervisión de
                                                        </p>
                                                        <p class="text-nowrap">
                                                            {{ $user->supervisor->first_name }}
                                                            {{ $user->supervisor->last_name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="rounded-r-2xl">
                                            <div class="flex items-center gap-2">
                                                <button
                                                    class="rounded-full relative p-2 hover:bg-neutral-200 transition-colors"
                                                    data-dropdown-toggle="dropdown-{{ $user->id }}">
                                                    @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                                                </button>
                                                <div id="dropdown-{{ $user->id }}" class="dropdown-content hidden">
                                                    <a href="/users/{{ $user->id }}"
                                                        class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                        Ver perfil
                                                    </a>
                                                    <a href="/users/{{ $user->id }}/schedules"
                                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                        Ver Horarios
                                                    </a>
                                                    <a href="/users/{{ $user->id }}/assists"
                                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                        Ver Asistencias
                                                    </a>
                                                    @if (($cuser->has('users:reset-password') && !$user->has('development')) || $cuser->isDev())
                                                        <button data-atitle="Restablecer contraseña"
                                                            data-adescription="Al confimar la contraseña se restablecerá al DNI del usuario: {{ $user->dni }}. ¿Desea continuar?"
                                                            data-param="/api/users/reset-password/{{ $user->id }}"
                                                            class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                            Restablecer contraseña
                                                        </button>
                                                    @endif
                                                    @if (($cuser->has('users:toggle-disable') && !$user->has('development')) || $cuser->isDev())
                                                        <button
                                                            data-atitle="{{ $user->status ? 'Desactivar' : 'Activar' }} usuario"
                                                            data-adescription="No podrás deshacer esta acción."
                                                            data-param="/api/users/toggle-status/{{ $user->id }}"
                                                            class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10 {{ $user->status ? 'text-red-600' : 'text-green-600' }}">
                                                            {{ $user->status ? 'Desactivar' : 'Activar' }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <footer class="px-5 py-4">
                            {!! $users->links() !!}
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
