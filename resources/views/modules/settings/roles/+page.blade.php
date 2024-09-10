@extends('modules.users.+layout')

@section('title', 'Puestos de trabajo')

@section('layout.users')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Cargos.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                <span>Agregar nuevo cargo.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo cargo
                    </header>
                    <form action="/api/roles" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.roles.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($roles as $role)
                    <div class="flex relative hover:bg-neutral-100 items-start p-2.5 gap-2">
                        @svg('fluentui-toolbox-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p>{{ $role->code }}-{{ $role->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                @svg('fluentui-people-28-o', 'w-5 h-5') {{ $role->users->count() }} usuarios asociados.
                            </p>
                            <p class="text-sm">
                                Dapartamento: {{ $role->department->name }}
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $role->id }}"
                            data-modal-toggle="dialog-{{ $role->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-5 h-5')
                        </button>
                        <div id="dialog-{{ $role->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar cargo: {{ $role->name }}
                                </header>
                                <form action="/api/roles/{{ $role->id }}" method="POST"
                                    id="dialog-{{ $role->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.roles.form', [
                                        'job' => $role,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $role->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $role->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $role->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                        </button>
                        <div id="dropdown-{{ $role->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Se eliminará el puesto de trabajo y todos los cargos asociados."
                                data-param="/api/roles/delete/{{ $role->id }}"
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
                <footer class="px-5 py-4">
                    {!! $roles->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
