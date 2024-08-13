@extends('modules.settings.+layout')

@section('title', 'Ajustes del sistema: Areas')

@section('layout.settings')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Areas de trabajo.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                @svg('bx-plus', 'w-5 h-5')
                <span>Agregar nueva area.</span>
            </button>
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nueva area de trabajo
                    </header>
                    <form action="/api/areas" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                        @include('modules.settings.areas.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <div class="flex flex-col divide-y">
                @forelse ($areas as $area)
                    <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                        @svg('bx-folder', 'w-5 h-5 mr-2')
                        <div class="flex-grow">
                            <p>{{ $area->code }}-{{ $area->name }}</p>
                            <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                {{ $area->departments->count() }} departamentos
                            </p>
                        </div>
                        <button type="button" data-modal-target="dialog-{{ $area->id }}"
                            data-modal-toggle="dialog-{{ $area->id }}"
                            class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                            @svg('bx-pencil', 'w-4 h-4')
                        </button>
                        <div id="dialog-{{ $area->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                            <div class="content lg:max-w-lg max-w-full">
                                <header>
                                    Editar area: {{ $area->name }}
                                </header>
                                <form action="/api/areas/{{ $area->id }}" method="POST"
                                    id="dialog-{{ $area->id }}-form"
                                    class="dinamic-form body grid gap-4 overflow-y-auto">
                                    @include('modules.settings.areas.form', [
                                        'area' => $area,
                                    ])
                                </form>
                                <footer>
                                    <button data-modal-hide="dialog-{{ $area->id }}" type="button">Cancelar</button>
                                    <button form="dialog-{{ $area->id }}-form" type="submit">
                                        Guardar</button>
                                </footer>
                            </div>
                        </div>
                        <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                            data-dropdown-toggle="dropdown-{{ $area->id }}">
                            @svg('bx-dots-vertical-rounded', 'w-4 h-4')
                        </button>
                        <div id="dropdown-{{ $area->id }}" class="dropdown-content hidden">
                            <button data-atitle="¿Estás seguro de eliminar?"
                                data-adescription="Se eliminarán todos los departamentos asociados y los usuarios asignados a estos departamentos."
                                data-param="/api/areas/delete/{{ $area->id }}"
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
                    {!! $areas->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
