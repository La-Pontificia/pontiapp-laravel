@extends('modules.users.+layout')

@section('title', 'Gestión de usuarios')

@section('layout.users')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        @include('modules.edas.nav')
        <h2 class="py-3 pb-0 font-semibold tracking-tight text-lg px-2">
            Lista de colaboradores
        </h2>
        @if ($current_user->hasPrivilege('edas:view'))
            <div class="overflow-auto flex-grow h-full pt-0">
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-3">
                            <th>Usuario</th>
                            <th>Bajo supervision de</th>
                            <th class="text-center">Edas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($users->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay colaboradores registrados
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($users as $user)
                                <tr
                                    class="[&>td]:py-2 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                    <td>
                                        <div class="flex p-2 items-center gap-3">
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-12',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-lg',
                                            ])
                                            <div>
                                                <p class="font-medium text-nowrap">
                                                    {{ $user->last_name }}, {{ $user->first_name }}
                                                </p>
                                                <p class="text-sm font-normal text-nowrap">
                                                    {{ $user->role_position->job_position->name }},
                                                    {{ $user->role_position->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="edas/{{ $user->id }}/eda" class="absolute inset-0 block"></a>
                                    </td>
                                    <td>
                                        @if ($user->supervisor_id)
                                            <div class="flex p-2 items-center gap-3">
                                                @include('commons.avatar', [
                                                    'src' => $user->supervisor->profile,
                                                    'className' => 'w-12',
                                                    'alt' =>
                                                        $user->supervisor->first_name .
                                                        ' ' .
                                                        $user->supervisor->last_name,
                                                    'altClass' => 'text-lg',
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
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="/edas/{{ $user->id }}" class="group-hover:underline text-blue-600">
                                            {{ $user->edas->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        <p class="opacity-70">
                                            {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }}
                                        </p>
                                    </td>
                                    {{-- <td>
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
                                                {{ $user->role_position->department->name }} -
                                                {{ $user->role_position->department->area->name }}
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
                                                    @if (($user->status && $current_user->hasPrivilege('users:disable')) || (!$user->status && $current_user->hasPrivilege('users:enable')))
                                                        <a href="#"
                                                            class="p-2 hover:bg-neutral-100 w-full block rounded-md text-red-500 hover:bg-gray-10">
                                                            {{ $user->status ? 'Deshabilitar' : 'Habilitar' }}
                                                        </a>
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
                                    </td> --}}
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
    </div>
@endsection
