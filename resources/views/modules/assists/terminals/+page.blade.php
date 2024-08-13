@extends('modules.assists.+layout')

@section('title', 'Asistencias: Ajustes de terminales')

@section('layout.assists')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="py-5">Bases de datos de terminales de asistencias.</h2>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('assists:terminals:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    @svg('bx-plus', 'w-5 h-5')
                    <span>Registrar nueva terminal</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Registrar nueva terminal
                        </header>
                        <form action="/assists/terminals" method="POST" id="dialog-form"
                            class="dinamic-form body grid gap-4">
                            @include('modules.assists.terminals.form')
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
                @if ($cuser->has('assists:terminals:show') || $cuser->isDev())
                    @forelse ($terminals as $terminal)
                        <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                            @svg('bx-data', 'w-5 h-5 mr-2')
                            <div class="flex-grow">
                                <p>{{ $terminal->name }}</p>
                                <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                    {{ $terminal->database_name }}
                                </p>
                            </div>
                            @if ($cuser->has('assists:terminals:edit') || $cuser->isDev())
                                <button type="button" data-modal-target="dialog-{{ $terminal->id }}"
                                    data-modal-toggle="dialog-{{ $terminal->id }}"
                                    class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                                    @svg('bx-pencil', 'w-4 h-4')
                                </button>
                            @endif
                            <div id="dialog-{{ $terminal->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar terminal: {{ $terminal->name }}
                                    </header>
                                    <form action="/assists/terminals/{{ $terminal->id }}" method="POST"
                                        id="dialog-{{ $terminal->id }}-form"
                                        class="dinamic-form body grid gap-4 overflow-y-auto">
                                        @include('modules.assists.terminals.form', [
                                            'terminal' => $terminal,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $terminal->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $terminal->id }}-form" type="submit">
                                            Guardar</button>
                                    </footer>
                                </div>
                            </div>
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $terminal->id }}">
                                @svg('bx-dots-vertical-rounded', 'w-4 h-4')
                            </button>
                            <div id="dropdown-{{ $terminal->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('assists:terminals:delete') || $cuser->isDev())
                                    <button data-atitle="¿Estás seguro de eliminar?"
                                        data-adescription="No podrás deshacer esta acción."
                                        data-param="/assists/terminals/delete/{{ $terminal->id }}"
                                        class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                        Eliminar
                                    </button>
                                @endif
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
