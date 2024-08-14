@extends('modules.users.+layout')

@section('title', 'Gestión de usuarios')

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

    <div class="w-full mx-auto p-2 h-full overflow-y-auto flex flex-col">
        <header class="py-2">
            <h2 class="text-base">Gestión de usuarios.</h2>
            <p class="text-sm">
                Administracion de los usuarios del sistema, asigna roles, horarios y privilegios.
            </p>
        </header>
        <div class="flex bg-white shadow-md border rounded-xl flex-col w-full overflow-y-auto h-full">
            <div class="flex items-center p-2">
                @if ($cuser->has('users:create') || $cuser->isDev())
                    <a tip="Crear nuevo usuario" href="/users/create" class="primary">
                        @svg('bx-plus', 'w-5 h-5')
                        <span>Nuevo</span>
                    </a>
                @endif
                @if ($cuser->has('users:export') || $cuser->isDev())
                    <button tip="Exportar lista de usuarios" data-dropdown-toggle="dropdown" class="secondary ml-auto">
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
                    <input value="{{ request()->get('q') }}" placeholder="Filtrar usuarios..." type="search"
                        class="w-full pl-9 dinamic-search">
                </label>

                <select class="dinamic-select w-[100px]" name="status">
                    <option value="0">Estado</option>
                    <option {{ request()->query('status') === 'actives' ? 'selected' : '' }} value="actives">Activos
                    </option>
                    <option {{ request()->query('status') === 'inactives' ? 'selected' : '' }} value="inactives">Inactivos
                    </option>
                </select>

                <select class="dinamic-select w-[70px]" name="role">
                    <option value="0">Rol</option>
                    @foreach ($user_roles as $role)
                        <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                            {{ $role->title }}</option>
                    @endforeach
                </select>

                <select class="dinamic-select w-[140px]" name="department">
                    <option value="0">Departamento</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <select class="dinamic-select w-[100px]" name="job_position">
                    <option value="0">Puesto</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col h-full divide-y overflow-y-auto">
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
                                    <td class="text-left pb-1.5">Bajo supervisión de </td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($users as $user)
                                    <tr class="relative even:bg-neutral-50 group hover:bg-neutral-50 [&>td]:p-3">
                                        <td>
                                            <div class="flex items-center gap-2">
                                                @include('commons.avatar', [
                                                    'src' => $user->profile,
                                                    'className' => 'w-12',
                                                    'alt' => $user->first_name . ' ' . $user->last_name,
                                                    'altClass' => 'text-xl',
                                                ])
                                                <div class="flex-grow">
                                                    <p class="text-nowrap font-medium">
                                                        {{ $user->last_name . ', ' . $user->first_name }}
                                                    </p>
                                                    <p
                                                        class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
                                                        {{ $user->role_position->name }},
                                                        {{ $user->role_position->department->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="text-sm text-nowrap {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-1 rounded-full">
                                                {{ $user->status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-nowrap">
                                                @svg('bx-envelope', 'w-4 h-4 inline-block mr-1')
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td>
                                            @if ($cuser->has('users:asign-supervisor') || $cuser->isDev())
                                                <button data-modal-target="dialog-{{ $user->id }}"
                                                    data-modal-toggle="dialog-{{ $user->id }}"
                                                    tip="Asignar o cambiar supervisor"
                                                    class="bg-neutral-100 relative text-left hover:bg-neutral-200 rounded-xl p-2 flex px-3 items-center gap-2">
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
                                                        @svg('bx-plus', 'w-5 h-5')
                                                        Asignar
                                                    @endif
                                                </button>

                                                <div id="dialog-{{ $user->id }}" tabindex="-1" aria-hidden="true"
                                                    class="dialog hidden">
                                                    <div class="content lg:max-w-lg max-w-full">
                                                        <header>
                                                            Asignar o cambiar supervisor
                                                        </header>

                                                        <div class="p-3 gap-4 overflow-y-auto flex flex-col">
                                                            @php
                                                                $defaultvalue = $user->supervisor_id
                                                                    ? $user->supervisor->first_name .
                                                                        ' ' .
                                                                        $user->supervisor->last_name
                                                                    : null;
                                                            @endphp
                                                            <div class="grid gap-2">
                                                                <label class="relative">
                                                                    <div
                                                                        class="absolute z-[1] inset-y-0 px-2 flex items-center">
                                                                        @svg('bx-search-alt-2', 'w-5 h-5 opacity-60')
                                                                    </div>
                                                                    <input value="{{ $defaultvalue }}"
                                                                        data-id="{{ $user->id }}" type="search"
                                                                        class="supervisor-input w-full"
                                                                        style="padding-left: 30px"
                                                                        placeholder="Correo, DNI, nombres...">
                                                                </label>
                                                                <div id="result-{{ $user->id }}"
                                                                    class="p-1 grid gap-2 text-center">
                                                                    <p class="p-10 text-neutral-500">
                                                                        No se encontraron resultados o no se ha realizado
                                                                        una
                                                                        búsqueda.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($user->supervisor_id)
                                                            <footer>
                                                                <button data-alertvariant="warning"
                                                                    data-param='/api/users/supervisor/remove/{{ $user->id }}'
                                                                    data-atitle='Remover supervisor'
                                                                    data-adescription='¿Estás seguro de que deseas remover el supervisor de este usuario?'
                                                                    type="button" class="secondary dinamic-alert">
                                                                    @svg('bx-user-minus', 'w-5 h-5')
                                                                    Remover
                                                                    supervisor</button>
                                                            </footer>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <button
                                                    class="rounded-full relative p-2 hover:bg-neutral-200 transition-colors"
                                                    data-dropdown-toggle="dropdown-{{ $user->id }}">
                                                    @svg('bx-dots-vertical-rounded', 'w-4 h-4')
                                                </button>
                                                <div id="dropdown-{{ $user->id }}" class="dropdown-content hidden">
                                                    <a href="/users/{{ $user->id }}"
                                                        class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                        Ver perfil
                                                    </a>
                                                    @if ($cuser->has('users:edit') || $cuser->isDev())
                                                        <a href="/users/{{ $user->id }}?view=edit"
                                                            class="p-2 hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                                            Editar perfil
                                                        </a>
                                                    @endif
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
                                                <a tip="Ver detalles" href="/users/{{ $user->id }}">
                                                    <p
                                                        class="rounded-full p-2 hover:bg-neutral-200 transition-colors block">
                                                        @svg('bx-chevron-right', 'w-5 h-5')
                                                    </p>
                                                </a>
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
