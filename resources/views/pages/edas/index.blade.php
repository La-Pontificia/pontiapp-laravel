@extends('layouts.eda')

@section('content-eda')
    <div class="text-black h-full w-full flex-grow flex flex-col overflow-y-auto">
        @include('components.edas.filters')
        <div class="overflow-y-auto">
            @if ($current_user->hasPrivilege('view_collaborators'))
                <div class="overflow-auto">
                    <table class="w-full text-left" id="table-users">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium text-sm [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                                <th class="min-w-[250px]">Colaborador</th>
                                <th class="min-w-[250px]">Supervisor</th>
                                <th>Registrado en</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count() === 0)
                                <tr class="">
                                    <td colspan="11" class="text-center py-4">
                                        <div class="p-10">
                                            No hay usuarios que mostrar
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr
                                        class="[&>td]:p-2 relative hover:bg-neutral-200 even:bg-white [&>td>p]:text-nowrap group [&>th>p]:text-nowrap [&>td]:px-2 [&>th]:px-2 [&>th]:font-medium">
                                        <th>
                                            <div class="flex p-2 items-center gap-3">
                                                <div class="w-9 rounded-xl overflow-hidden aspect-square">
                                                    <img src={{ $user->profile }} class="w-full h-full object-cover"
                                                        alt="">
                                                </div>
                                                <div>
                                                    <p class="text-sm">
                                                        {{ $user->last_name }}, {{ $user->first_name }}
                                                    </p>
                                                    <p class="text-sm font-normal">
                                                        {{ $user->role_position->job_position->name }},
                                                        {{ $user->role_position->name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('edas.user', ['id_user' => $user->id]) }}"
                                                class="absolute inset-0 block"></a>
                                        </th>
                                        <th>
                                            @if ($user->id_supervisor)
                                                <div class="flex p-2 items-center gap-3">
                                                    <div class="w-9 rounded-xl overflow-hidden aspect-square">
                                                        <img src={{ $user->supervisor->profile }}
                                                            class="w-full h-full object-cover" alt="">
                                                    </div>
                                                    <div>
                                                        <p class="text-sm">
                                                            {{ $user->supervisor->last_name }},
                                                            {{ $user->supervisor->first_name }}
                                                        </p>
                                                        <p class="text-sm font-normal">
                                                            {{ $user->supervisor->role_position->job_position->name }},
                                                            {{ $user->supervisor->role_position->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </th>
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
