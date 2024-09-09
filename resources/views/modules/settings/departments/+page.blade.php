@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Departamentos')

@section('layout.settings')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Departamentos.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                <span>Agregar nuevo departamento.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo departamento
                    </header>
                    <form action="/api/departments" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.departments.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($departments as $department)
                    <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                        @svg('fluentui-building-home-20-o', 'w-6 h-6 mr-2')
                        <div class="flex-grow">
                            <p>{{ $department->code }}-{{ $department->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                {{ $department->roles->count() }} cargos.
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $department->id }}"
                            data-modal-toggle="dialog-{{ $department->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('fluentui-edit-20', 'w-4 h-4')
                        </button>
                        <div id="dialog-{{ $department->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar departamento: {{ $department->name }}
                                </header>
                                <form action="/api/departments/{{ $department->id }}" method="POST"
                                    id="dialog-{{ $department->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.departments.form', [
                                        'department' => $department,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $department->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $department->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $department->id }}">
                            @svg('fluentui-more-horizontal-20-o', 'w-4 h-4')
                        </button>
                        <div id="dropdown-{{ $department->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Se eliminarán todos los departamentos asociados y los usuarios asignados a estos departamentos."
                                data-param="/api/departments/delete/{{ $department->id }}"
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
                    {!! $departments->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
