@extends('modules.users.+layout')

@section('title', 'Privilegios de usuario')

@section('layout.users')
    <div class="h-full flex flex-col">
        @if ($current_user->hasPrivilege('users:user-roles:create'))
            <div class="flex">
                <a href="/users/user-roles/create"
                    class="bg-blue-700 shadow-md shadow-blue-500/30 font-semibold hover:bg-blue-600 min-w-max flex items-center rounded-full p-2 gap-1 text-white text-sm px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <span class="max-lg:hidden">Nuevo rol</span>
                </a>
            </div>
        @endif
        <h2 class="py-3 font-semibold tracking-tight text-lg px-1">
            Gestión de roles
        </h2>
        @if ($current_user->hasPrivilege('users:user-roles:view'))
            <div class="bg-white shadow-sm rounded-2xl">
                <table class="w-full text-left" id="table-users">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-1.5 [&>th]:px-2">
                            <th class="w-max font-semibold tracking-tight">Rol</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @if ($roles->count() === 0)
                            <tr class="">
                                <td colspan="11" class="text-center py-4">
                                    <div class="p-10">
                                        No hay roles disponibles
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($roles as $role)
                                <tr
                                    class="[&>td]:py-3 hover:border-transparent hover:[&>td]shadow-md [&>td>p]:text-nowrap relative group first:[&>td]:rounded-l-2xl last:[&>td]:rounded-r-2xl hover:bg-white [&>td]:px-2">
                                    <td>
                                        <div class="flex gap-2 items-center">
                                            <p class="text-nowrap">
                                                <a href="/users/user-roles/{{ $role->id }}"
                                                    class="hover:underline hover:text-blue-600">
                                                    {{ $role->title }}
                                                </a>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="relative">
                                        <div class="flex items-center gap-2">
                                            <p>
                                                <a href="/users/user-roles/{{ $role->id }}"
                                                    class="hover:underline text-blue-600">
                                                    {{ count($role->privileges) }} privilegios
                                                </a>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="opacity-70">
                                            Registrado el {{ \Carbon\Carbon::parse($role->created_at)->isoFormat('LL') }}
                                            por
                                            {{ $role->createdBy->first_name }} {{ $role->createdBy->last_name }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            @include('+403', [
                'message' => 'No tienes permisos para ver los roles de los usuarios.',
            ])
        @endif
    </div>
@endsection
