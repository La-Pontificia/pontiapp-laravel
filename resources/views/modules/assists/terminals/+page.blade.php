@extends('modules.assists.+layout')

@section('title', 'Asistencias: Ajustes de terminales')

@section('layout.assists')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Bases de datos de terminales de asistencias (Biometricos).</h2>
        <form class="flex dinamic-form-to-params pb-4 items-center gap-4">
            <label class="relative mt-6 ml-auto w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..." type="search"
                    class="pl-9 w-full bg-white" style="padding-left: 35px">
            </label>
            <button class="primary mt-6">
                Filtrar
            </button>
        </form>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('assists:terminals:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    @svg('fluentui-add-circle-16-o', 'w-5 h-5')
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
                        <div class="flex relative items-center p-2.5 gap-2">
                            @svg('fluentui-calculator-20-o', 'w-5 h-5 mr-2')
                            <div class="flex-grow">
                                <p class="font-semibold">{{ $terminal->name }}</p>
                                <p class="flex text-nowrap text-sm items-center flex-wrap gap-1 text-neutral-600">
                                    {{ $terminal->database_name }}
                                </p>
                            </div>
                            @if ($cuser->has('assists:terminals:edit') || $cuser->isDev())
                                <button type="button" data-modal-target="dialog-{{ $terminal->id }}"
                                    data-modal-toggle="dialog-{{ $terminal->id }}"
                                    class="rounded-full p-2 hover:bg-stone-200 transition-colors">
                                    @svg('fluentui-edit-20', 'w-5 h-5')
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
                            <button class="rounded-full p-2 hover:bg-stone-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $terminal->id }}">
                                @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                            </button>
                            <div id="dropdown-{{ $terminal->id }}" class="dropdown-content hidden">
                                @if ($cuser->has('assists:terminals:delete') || $cuser->isDev())
                                    <button data-atitle="¿Estás seguro de eliminar?"
                                        data-adescription="No podrás deshacer esta acción."
                                        data-param="/assists/terminals/delete/{{ $terminal->id }}"
                                        class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
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
