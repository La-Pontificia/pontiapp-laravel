@extends('modules.tickets.settings.+layout')

@section('title', 'Ajustes de modulo de Tickets')

@php
    $states = [
        'open' => [
            'name' => 'Abierto',
            'class' => 'bg-green-500/10 text-lime-600',
        ],
        'closed' => [
            'name' => 'Cerrado',
            'class' => 'bg-red-500/10 text-red-600',
        ],
    ];
@endphp

@section('layout.tickets.settings')
    <div class="w-full flex pt-1 flex-col flex-grow">
        <nav class="px-2 pb-2">
            <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                <div class="content lg:max-w-lg max-w-full">
                    <header>
                        Registrar nuevo modulo de Tickets.
                    </header>
                    <form action="/api/tickets/settings/modules" method="POST" id="dialog-form"
                        class="dinamic-form body grid gap-4">
                        @include('modules.tickets.settings.modules.form')
                    </form>
                    <footer>
                        <button data-modal-hide="dialog" type="button">Cancelar</button>
                        <button form="dialog-form" type="submit">
                            Guardar</button>
                    </footer>
                </div>
            </div>
            <form class="flex dinamic-form-to-params p-1 items-center flex-wrap gap-2">
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog" class="primary flex mt-5">
                    @svg('fluentui-add-circle-16-o', 'w-5 h-5')
                    <span>Nuevo</span>
                </button>


                <label class="label">
                    <span>Unidad de negocio:</span>
                    <select class="bg-white" name="business">
                        <option value="" selected>Todos</option>
                        @foreach ($businessUnits as $business)
                            <option {{ request()->query('business') === $business->id ? 'selected' : '' }}
                                value="{{ $business->id }}">{{ $business->businessUnit->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="relative mt-6 w-[200px] max-w-full">
                    <div class="absolute inset-y-0 z-10 text-neutral-400 grid place-content-center left-2">
                        @svg('fluentui-search-28-o', 'w-5 h-5')
                    </div>
                    <input value="{{ request()->get('query') }}" name="query" placeholder="Filtrar modulos..."
                        type="search" class="pl-9 w-full bg-white">
                </label>

                <button class="primary mt-6">
                    Filtrar
                </button>
            </form>
        </nav>
        <div class="flex flex-grow bg-white rounded-xl shadow-md w-full">
            <div class="w-full">
                <table class="w-full">
                    <thead>
                        <tr class="border-b text-sm [&>td]:p-2">
                            <td class="font-medium text-center">#</td>
                            <td class="font-medium opacity-70">Nombre</td>
                            <td class="font-medium opacity-70">Estado</td>
                            <td class="font-medium opacity-70">Unidad de N.</td>
                            <td class="font-medium opacity-70"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketModules as $module)
                            <tr class="relative group border-b [&>td]:p-2">
                                <td class="text-center">
                                    <p class="font-semibold text-lg">
                                        # {{ $module->number }}
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        {{ $module->name }}
                                    </p>
                                </td>
                                <td>
                                    <div>
                                        <span
                                            class="rounded-full text-sm font-medium px-2 py-0.5 {{ $states[$module->state]['class'] }}">
                                            {{ $states[$module->state]['name'] }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    {{ $module->business ? $module->business->businessUnit->name : '-' }}
                                </td>
                                <td>
                                    <div id="dialog-{{ $module->id }}" tabindex="-1" aria-hidden="true"
                                        class="dialog hidden">
                                        <div class="content lg:max-w-lg max-w-full">
                                            <header>
                                                Editar modulo de Tickets #{{ $module->number }}
                                            </header>
                                            <form action="/api/tickets/settings/modules/{{ $module->id }}" method="POST"
                                                id="dialog-form-{{ $module->id }}" class="dinamic-form body grid gap-4">
                                                @include('modules.tickets.settings.modules.form', [
                                                    'module' => $module,
                                                ])
                                            </form>
                                            <footer>
                                                <button data-modal-hide="dialog-{{ $module->id }}"
                                                    type="button">Cancelar</button>
                                                <button form="dialog-form-{{ $module->id }}" type="submit">
                                                    Actualizar
                                                </button>
                                            </footer>
                                        </div>
                                    </div>
                                    <button class="rounded-full p-2 hover:bg-stone-200 transition-colors"
                                        data-dropdown-toggle="dropdown-{{ $module->id }}">
                                        @svg('fluentui-more-horizontal-20-o', 'w-5 h-5')
                                    </button>
                                    <div id="dropdown-{{ $module->id }}" class="dropdown-content hidden">
                                        <button type="button" data-modal-target="dialog-{{ $module->id }}"
                                            data-modal-toggle="dialog-{{ $module->id }}"
                                            class="p-2 hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                            <span>Editar</span>
                                        </button>
                                        <button data-atitle="¿Estás seguro de eliminar?"
                                            data-adescription="Esta acción no se puede deshacer."
                                            data-param="/api/tickets/settings/modules/delete/{{ $module->id }}"
                                            class="p-2 dinamic-alert hover:bg-stone-100 text-left w-full block rounded-md hover:bg-gray-10">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer class="px-5 py-4">
                    {!! $ticketModules->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
