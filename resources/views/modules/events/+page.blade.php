@extends('modules.events.+layout')

@section('title', 'Gestión Eventos')

@section('layout.events')
    <div class="w-full max-w-2xl mx-auto">
        <h2 class="pt-5">Eventos.</h2>
        <form class="flex dinamic-form-to-params pb-4 items-center gap-4">
            <label class="relative mt-6 ml-auto w-full max-w-full">
                <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                    @svg('fluentui-search-28-o', 'w-5 h-5')
                </div>
                <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar..." type="search"
                    class="pl-9 w-full bg-white">
            </label>
            <button class="primary mt-6">
                Filtrar
            </button>
        </form>
        <div class="flex flex-col w-full bg-white border-neutral-300 shadow-[0_0_10px_rgba(0,0,0,.2)] border rounded-xl">
            @if ($cuser->has('events:create') || $cuser->isDev())
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary m-2">
                    @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                    <span>Nuevo evento.</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Registrar nuevo evento
                        </header>
                        <form action="/api/events" method="POST" id="dialog-form" class="dinamic-form body grid gap-4">
                            @include('modules.events.form')
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
                @forelse ($events as $event)
                    <div class="flex relative hover:bg-neutral-100 items-center p-2.5 gap-2">
                        @svg('fluentui-megaphone-loud-20-o', 'w-5 h-5 mr-2')
                        <div class="flex-grow">
                            <p class="font-medium">{{ $event->name }}</p>
                            <p class="flex text-nowrap text-xs items-center flex-wrap gap-1 text-neutral-600">
                                {{ $event->start_date->format('d/m/Y') }} - {{ $event->end_date->format('d/m/Y') }}
                            </p>
                        </div>
                        @if ($cuser->has('events:edit') || $cuser->isDev())
                            <button type="button" data-modal-target="dialog-{{ $event->id }}"
                                data-modal-toggle="dialog-{{ $event->id }}"
                                class="rounded-full p-2 hover:bg-neutral-200 transition-colors">
                                @svg('fluentui-edit-20', 'w-5 h-5')
                            </button>
                            <div id="dialog-{{ $event->id }}" tabindex="-1" aria-hidden="true" class="dialog hidden">
                                <div class="content lg:max-w-lg max-w-full">
                                    <header>
                                        Editar area: {{ $event->name }}
                                    </header>
                                    <form action="/api/events/{{ $event->id }}" method="POST"
                                        id="dialog-{{ $event->id }}-form"
                                        class="dinamic-form body grid gap-4 overflow-y-auto">
                                        @include('modules.events.form', [
                                            'event' => $event,
                                        ])
                                    </form>
                                    <footer>
                                        <button data-modal-hide="dialog-{{ $event->id }}"
                                            type="button">Cancelar</button>
                                        <button form="dialog-{{ $event->id }}-form" type="submit">
                                            Actualizar</button>
                                    </footer>
                                </div>
                            </div>
                        @endif
                        @if ($cuser->has('events:delete') || $cuser->isDev())
                            <button class="rounded-full p-2 hover:bg-neutral-200 transition-colors"
                                data-dropdown-toggle="dropdown-{{ $event->id }}">
                                @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                            </button>
                            <div id="dropdown-{{ $event->id }}" class="dropdown-content hidden">
                                <button data-atitle="¿Estás seguro de eliminar?"
                                    data-adescription="Se eliminarán todos los registros que asistieron a este evento."
                                    data-param="/api/events/{{ $event->id }}/delete"
                                    class="p-2 dinamic-alert hover:bg-neutral-100 text-left w-full block rounded-md hover:bg-gray-10">
                                    Eliminar
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="p-20 grid place-content-center text-center">
                        No hay nada que mostrar.
                    </p>
                @endforelse
                @if ($events->count() > 19)
                    <footer class="px-5 py-4">
                        {!! $events->links() !!}
                    </footer>
                @endif
            </div>
        </div>
    </div>
@endsection
