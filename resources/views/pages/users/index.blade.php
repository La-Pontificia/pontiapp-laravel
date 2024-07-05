@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        {{-- @include('components.users.nav') --}}
        <div class="overflow-y-auto">
            @if ($current_user->hasPrivilege('view_users'))
                <div class="overflow-auto p-2">
                    <table class="w-full text-left" id="table-users">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                                <th></th>
                                <th class="text-lg font-semibold tracking-tight">Nombres y apellidos</th>
                                <th></th>
                                <th></th>
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
                                        class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                        <td>
                                            @include('commons.avatar', [
                                                'src' => $user->profile,
                                                'className' => 'w-12',
                                                'alt' => $user->first_name . ' ' . $user->last_name,
                                                'altClass' => 'text-lg',
                                            ])
                                        </td>
                                        <td>
                                            <a class="absolute inset-0" href="/profile/{{ $user->id }}">
                                            </a>
                                            <p class="text-sm font-normal">
                                                <span class="text-base block font-semibold">
                                                    {{ $user->last_name }},
                                                    {{ $user->first_name }}</span>
                                                {{ $user->role_position->name }},
                                                {{ $user->role_position->department->name }} -
                                                {{ $user->role_position->department->area->name }}
                                            </p>
                                        </td>
                                        {{-- <td>
                                            <p>
                                                {{ $user->dni }}
                                            </p>
                                        </td> --}}
                                        <td class="relative">
                                            <a href="mailto:{{ $user->email }}"
                                                class="bg-white flex items-center gap-1 rounded-xl hover:shadow-lg shadow-md p-3 w-fit">
                                                <img src="/elp.webp" class="w-8" />
                                                {{ $user->email }}
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="opacity-0 group-hover:opacity-100" width="15"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-square-arrow-out-up-right group-hover:opacity-100">
                                                    <path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6" />
                                                    <path d="m21 3-9 9" />
                                                    <path d="M15 3h6v6" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td>
                                            <p class="opacity-70">
                                                {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('LL') }}
                                            </p>
                                        </td>
                                        <td class="relative">
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
