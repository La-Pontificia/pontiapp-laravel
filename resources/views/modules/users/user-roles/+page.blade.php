@extends('modules.users.+layout')

@section('title', 'Privilegios de usuario')

@section('layout.users')
    <div class="w-full max-w-5xl mx-auto">
        <h2 class="py-5">Roles y privilegios de usuarios.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('users:user-roles:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    @svg('bx-plus', 'w-5 h-5')
                    <span>Nuevo rol</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Agregar nuevo rol
                        </header>
                        <form data-redirect='/users/user-roles' action="/api/user-roles" method="POST" id="dialog-form"
                            class="dinamic-form body grid gap-4">
                            @include('modules.users.user-roles.form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
                        </footer>
                    </div>
                </div>
            @endif
            <div class="flex flex-col divide-y">
                @if ($cuser->has('users:user-roles:show') || $cuser->isDev())
                    @forelse ($roles as $role)
                        <div class="flex relative items-center p-3 gap-2">
                            @svg('bx-folder', 'w-5 h-5 mr-2')
                            <div class="flex-grow">
                                <p>{{ $role->title }}</p>
                                <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                    @svg('bx-folder', 'w-4 h-4')
                                    {{ count($role->privileges) }} privilegios. @svg('bx-group', 'w-4 h-4') {{ count($role->users) }}
                                </p>
                            </div>
                            <button type="button" data-modal-target="dialog-{{ $role->id }}"
                                data-modal-toggle="dialog-{{ $role->id }}"
                                class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                                @svg('bx-pencil', 'w-4 h-4')
                            </button>
                            <div id="dialog-{{ $role->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar rol: {{ $role->title }}
                                    </header>
                                    <form data-redirect='/users/user-roles' action="/api/user-roles/{{ $role->id }}"
                                        method="POST" id="dialog-{{ $role->id }}-form"
                                        class="dinamic-form body grid gap-4 overflow-y-auto">
                                        @include('modules.users.user-roles.form', [
                                            'role' => $role,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $role->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $role->id }}-form" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $role->id }}">
                                @svg('bx-dots-vertical-rounded', 'w-4 h-4')
                            </button>
                            <div id="dropdown-{{ $role->id }}" class="dropdown-content hidden">
                                <button data-alertvariant="warning" data-atitle="¿Estás seguro de eliminar el rol?"
                                    data-adescription="No podrás deshacer esta acción."
                                    data-param="/api/user-roles/delete/{{ $role->id }}"
                                    class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="p-20 grid place-content-center text-center">
                            No hay nada que mostrar.
                        </p>
                    @endforelse
                @else
                    <p class="p-20 grid place-content-center text-center">
                        No tienes permisos para visualizar estos datos.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
