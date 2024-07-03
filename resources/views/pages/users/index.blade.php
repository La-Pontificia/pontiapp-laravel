@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        @include('components.users.nav')
        <div class="overflow-y-auto">
            @if ($current_user->hasPrivilege('view_users'))
                <div class="overflow-auto">
                    <table class="w-full text-left" id="table-users">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium text-sm [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                                <th></th>
                                <th></th>
                                <th>Apellidos</th>
                                <th class="w-full">Nombres</th>
                                <th>DNI</th>
                                <th class="w-full">Correo</th>
                                <th>Area & Departamento</th>
                                <th>Puesto & Cargo</th>
                                <th>Registrado en</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @if ($users->count() === 0)
                                <tr class="">
                                    <td colspan="11" class="text-center py-4">
                                        <div class="p-10">
                                            No hay usuarios registrados
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr
                                        class="[&>td]:p-2 [&>td>p]:text-nowrap group [&>th>p]:text-nowrap [&>td]:px-2 [&>th]:px-2 [&>th]:font-medium">
                                        <th>
                                            <input id="default-checkbox" data-id="{{ $user->id }}" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        </th>
                                        <th>
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-8',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-sm',
                                            ])
                                        </th>
                                        <th>
                                            <p class="text-sm">
                                                <a class="hover:underline" href="/profile/{{ $user->id }}">
                                                    {{ $user->last_name }}
                                                </a>
                                            </p>
                                        </th>
                                        <th>
                                            <p class="text-sm">
                                                <a class="hover:underline" href="/profile/{{ $user->id }}">
                                                    {{ $user->first_name }}
                                                </a>
                                            </p>
                                        </th>
                                        <td>
                                            <p>
                                                {{ $user->dni }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm">
                                                {{ $user->role_position->department->area->name }},
                                                {{ $user->role_position->department->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm">
                                                {{ $user->role_position->job_position->name }},
                                                {{ $user->role_position->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="opacity-70">
                                                {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }}
                                            </p>
                                        </td>
                                        <td>
                                            <button id="dropdownDividerButton"
                                                data-dropdown-toggle="dropdown-user-{{ $user->id }}"
                                                class="group-hover:opacity-100 opacity-0">
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
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow w-44">
                                                <ul class="py-1 text-sm text-black" aria-labelledby="dropdownDividerButton">
                                                    @if ($current_user->hasPrivilege('edit_users'))
                                                        <li>
                                                            <a href="{{ route('users.edit', $user->id) }}"
                                                                class="block px-2 py-2 hover:bg-gray-100">Editar</a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="#"
                                                            class="block px-2 py-2 hover:bg-gray-100">Asistencias</a>
                                                    </li>

                                                </ul>
                                                @if ($user->role !== 'dev')
                                                    <a href="#"
                                                        class="block px-2 py-2 text-sm text-red-500 hover:bg-gray-10">Desactivar</a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @else
                <div>
                    <p>No tienes permisos para ver esta página</p>
                </div>
            @endif
        </div>
        <footer class="px-5 pt-4">
            {!! $users->links() !!}
        </footer>
    </div>
@endsection
