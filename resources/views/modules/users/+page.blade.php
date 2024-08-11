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

    <div class="w-full max-w-5xl mx-auto">
        <header class="py-5">
            <h2 class="text-base">Gestión de usuarios.</h2>
            <p class="text-sm">
                Administracion de los usuarios del sistema, asigna roles, horarios y privilegios.
            </p>
        </header>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <div class="flex items-center p-2">
                @if ($cuser->has('users:create') || $cuser->isDev())
                    <a href="/users/create" class="primary">
                        @svg('bx-plus', 'w-5 h-5')
                        <span>Nuevo</span>
                    </a>
                @endif
                @if ($cuser->has('users:schedules:export') || $cuser->isDev())
                    <button data-dropdown-toggle="dropdown" class="secondary ml-auto">
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
                <select class="dinamic-select" name="status">
                    <option value="0">Todos los estados</option>
                    <option {{ request()->query('status') === 'actives' ? 'selected' : '' }} value="actives">Activos
                    </option>
                    <option {{ request()->query('status') === 'inactives' ? 'selected' : '' }} value="inactives">Inactivos
                    </option>
                </select>

                <select class="dinamic-select" name="role">
                    <option value="0">Todos los roles</option>
                    @foreach ($user_roles as $role)
                        <option {{ request()->query('role') === $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                            {{ $role->title }}</option>
                    @endforeach
                </select>

                <select class="dinamic-select" name="department">
                    <option value="0">Todos los departentos</option>
                    @foreach ($departments as $department)
                        <option {{ request()->query('department') === $department->id ? 'selected' : '' }}
                            value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                <select class="dinamic-select" name="job_position">
                    <option value="0">Todos los puestos</option>
                    @foreach ($job_positions as $job)
                        <option {{ request()->query('job_position') === $job->id ? 'selected' : '' }}
                            value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col divide-y">
                @if ($cuser->has('users:users:show') || $cuser->isDev())
                    @if ($users->isEmpty())
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th class="w-full"></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($users as $user)
                                    <tr class="relative group hover:bg-neutral-100 [&>td]:p-3">
                                        <td>
                                            <a title="Ver usuario" href="/users/{{ $user->id }}"
                                                class="absolute inset-0">
                                            </a>
                                            <div class="flex items-center gap-2">
                                                @include('commons.avatar', [
                                                    'src' => $user->profile,
                                                    'className' => 'w-8',
                                                    'alt' => $user->first_name . ' ' . $user->last_name,
                                                    'altClass' => 'text-base',
                                                ])
                                                <div class="flex-grow">
                                                    <p class="group-hover:underline text-nowrap">
                                                        {{ $user->last_name . ', ' . $user->first_name }}
                                                    </p>
                                                    <p
                                                        class="line-clamp-2 flex text-sm items-center gap-1 text-neutral-600">
                                                        @svg('bx-briefcase-alt-2', 'w-3 h-3')
                                                        {{ $user->role_position->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td>
                                            <p class="rounded-full p-2 hover:bg-neutral-200 transition-colors block">
                                                @svg('bx-chevron-right', 'w-5 h-5')
                                            </p>
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
    {{-- <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        @include('modules.users.nav')
        <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-2">
            Usuarios
        </h2>

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

        @if ($cuser->has('users:show') || $cuser->isDev())
            <div class="overflow-auto flex-grow h-full pt-0">
                <table class="w-full text-left" id="table-users">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                            <th></th>
                            <th>Bajo supervision de </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($users->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay nada por aquí
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($users as $user)
                                <tr
                                    class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-[#f8fbfd] [&>td]:px-2">
                                    <td>
                                        <div class="flex items-center gap-4">
                                            <a class="absolute inset-0" href="/users/{{ $user->id }}">
                                            </a>
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-12',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-lg',
                                            ])
                                            <p class="text-sm font-normal flex-grow text-nowrap">
                                                <span class="text-base block font-semibold">
                                                    {{ $user->last_name }},
                                                    {{ $user->first_name }}</span>
                                                {{ $user->role_position->name }},
                                                {{ $user->role_position->department->name }}
                                            </p>
                                            <div class="relative flex items-center">
                                                <button id="dropdownDividerButton"
                                                    data-dropdown-toggle="dropdown-user-{{ $user->id }}"
                                                    class="group-hover:opacity-100 opacity-0 hover:bg-neutral-200/80 rounded-md p-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-ellipsis">
                                                        <circle cx="12" cy="12" r="1" />
                                                        <circle cx="19" cy="12" r="1" />
                                                        <circle cx="5" cy="12" r="1" />
                                                    </svg>
                                                </button>
                                                <div id="dropdown-user-{{ $user->id }}"
                                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl p-1 shadow-xl w-60">
                                                    <button
                                                        class="p-2 text-left hover:bg-neutral-100 w-full block rounded-md">Restablecer
                                                        contraseña</button>
                                                    <a href="/users/{{ $user->id }}/schedules"
                                                        class="p-2 hover:bg-neutral-100 w-full block rounded-md">Horario
                                                        de trabajo</a>
                                                    @if (($user->status && $cuser->has('users:disable')) || (!$user->status && $cuser->has('users:enable')))
                                                        <a href="#"
                                                            class="p-2 hover:bg-neutral-100 w-full block rounded-md text-red-500 hover:bg-gray-10">
                                                            {{ $user->status ? 'Deshabilitar' : 'Habilitar' }}
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button data-modal-target="dialog-{{ $user->id }}"
                                            data-modal-toggle="dialog-{{ $user->id }}"
                                            class="p-2 relative text-left flex items-center gap-1 rounded-xl px-3 bg-white shadow-md font-semibold text-sm hover:shadow-lg">
                                            @if ($user->supervisor_id)
                                                @svg('heroicon-o-user-minus', ['class' => 'w-5 h-5'])
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
                                                    <p class="font-medium text-nowrap">
                                                        {{ $user->supervisor->last_name }},
                                                        {{ $user->supervisor->first_name }}
                                                    </p>
                                                    <p class="text-sm font-normal text-nowrap">
                                                        {{ $user->supervisor->role_position->job_position->name }},
                                                        {{ $user->supervisor->role_position->name }}
                                                    </p>
                                                </div>
                                            @else
                                                @svg('heroicon-o-user-plus', ['class' => 'w-5 h-5'])
                                                Asignar
                                            @endif
                                        </button>

                                        <div id="dialog-{{ $user->id }}" data-modal-backdrop="static" tabindex="-1"
                                            aria-hidden="true"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div
                                                class="relative p-4 overflow-y-auto w-full flex flex-col max-w-xl max-h-full">
                                                <div
                                                    class="relative overflow-y-auto flex flex-col bg-white rounded-2xl shadow">
                                                    <div class="flex items-center justify-between p-3 border-b rounded-t">
                                                        <h3 class="text-lg font-semibold text-gray-900">
                                                            Nuevo horario
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                            data-modal-hide="dialog-{{ $user->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    @include('components.users.auditory-card')
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
                                                                    @svg('heroicon-o-magnifying-glass', [
                                                                        'class' => 'w-5 h-5 opacity-60',
                                                                    ])
                                                                </div>
                                                                <input value="{{ $defaultvalue }}"
                                                                    data-id="{{ $user->id }}" type="search"
                                                                    class="supervisor-input" style="padding-left: 30px"
                                                                    placeholder="Correo, DNI, nombres...">
                                                            </label>
                                                            <div id="result-{{ $user->id }}"
                                                                class="p-2 grid gap-2 text-center">
                                                                <p class="p-10 text-neutral-500">
                                                                    No se encontraron resultados o no se ha realizado una
                                                                    búsqueda.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($user->supervisor_id)
                                                        <div
                                                            class="flex items-center p-3 border-t border-gray-200 rounded-b">
                                                            <button data-alertvariant="warning"
                                                                data-param='/api/users/supervisor/remove/{{ $user->id }}'
                                                                data-atitle='Remover supervisor'
                                                                data-adescription='¿Estás seguro de que deseas remover el supervisor de este usuario?'
                                                                type="button"
                                                                class="py-2.5 dinamic-alert px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-xl border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Remover
                                                                supervisor</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="relative">
                                        <div class="flex items-center gap-2">
                                            <a href="mailto:{{ $user->email }}"
                                                title="Enviar correo a {{ $user->email }}"
                                                class="bg-white flex text-sm items-center gap-1 rounded-xl hover:shadow-lg shadow-md p-3 font-medium w-fit">
                                                {{ $user->email }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="opacity-70">
                                            {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <footer class="px-5 pt-4">
                {!! $users->links() !!}
            </footer>
        @else
            @include('+403', [
                'message' => 'No tienes permisos para ver usuarios',
            ])
        @endif
    </div> --}}
@endsection
